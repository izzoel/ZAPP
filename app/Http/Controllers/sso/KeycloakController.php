<?php

namespace App\Http\Controllers\sso;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
class KeycloakController extends Controller
{
    public function redirect(Request $request)
    {
        if ($request->filled('redirect_url')) {
            // simpan tujuan akhir setelah login
            session(['redirect_url' => $request->get('redirect_url')]);
        }

        // Socialite akan menambahkan state CSRF otomatis
        return Socialite::driver('keycloak')->redirect();
    }

    public function callback(Request $request)
    {
        // Ambil user dari Keycloak via Socialite
        // stateless() dipakai jika kamu tidak ingin memverifikasi state lewat session
        // Jika kamu ingin verifikasi state pakai tanpa stateless() (default)
        $kcUser = Socialite::driver('keycloak')->stateless()->user();

        // Ambil token jika perlu
        $token = $kcUser->token ?? null;

        $user = User::updateOrCreate(
            ['email' => $kcUser->getEmail()],
            ['name' => $kcUser->getName(),
            'keycloak_id' => $kcUser->getId()
            ]
        );

        if ($user->wasRecentlyCreated && !$user->avatar) {
            $user->avatar = rand(0, 11) . '.png';
            $user->save();
        }

        // Login user
        Auth::login($user);

        Log::info('SSO Login: ' . $user->email);

        // Ambil tujuan akhir dari session, default /admin
        $redirectUrl = session()->pull('redirect_url', '/admin');

        return redirect()->to($redirectUrl);
    }

    public function logout(Request $request)
    {
        // logout lokal
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // halaman yang akan menerima post-logout dari Keycloak
        $postLogoutRedirect = url('/auth/logged-out');

        $logoutUrl = config('services.keycloak.base_url') .
        '/realms/' . config('services.keycloak.realms') .
        '/protocol/openid-connect/logout' .
        '?post_logout_redirect_uri=' . urlencode($postLogoutRedirect) .
        '&client_id=' . config('services.keycloak.client_id');

        return redirect()->away($logoutUrl);
    }

    public function loggedOut()
    {
        // bisa diarahkan ke login page atau root
        return redirect('/');
    }

    public function cekServer()
    {
        try {
            $url = env('KEYCLOAK_BASE_URL').'/realms/'. env('KEYCLOAK_REALM');
            $response = Http::timeout(2)->get($url);

            return ['online' => $response->successful()];
        } catch (Exceptions $e) {
            return ['online' => false];
        }
    }
}
