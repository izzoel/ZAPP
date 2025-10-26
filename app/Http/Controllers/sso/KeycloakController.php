<?php

namespace App\Http\Controllers\sso;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
class KeycloakController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('keycloak')->redirect();
    }

    public function callback(Request $request)
    {
        $kcUser = Socialite::driver('keycloak')->user();

        $token = $kcUser->accessTokenResponseBody['access_token'];
        $payload = json_decode(base64_decode(explode('.', $token)[1]), true);
        $roles = $payload['realm_access']['roles'] ?? [];

        $customRoles = collect($roles)->reject(function ($role) {
            return in_array($role, [
                'offline_access',
                'uma_authorization',
                'default-roles-zapp',
            ]);
        })->values()->all();

        $existingUser = User::where('email', $kcUser->getEmail())->first();

        if ($existingUser) {
            $existingUser->update([
                'name' => $kcUser->getName(),
            ]);
            $user = $existingUser;
        } else {
            $user = User::create([
                'keycloak_id' => $kcUser->getId(),
                'name' => $kcUser->getName(),
                'email' => $kcUser->getEmail(),
                'avatar' => rand(0, 10) . '.png',
            ]);
        }

        foreach ($customRoles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
        $user->syncRoles($customRoles);

        Auth::login($user);

        Log::info('### SSO Login ###');
        Log::info("\t+ Name\t: " . $kcUser->getName());
        Log::info("\t+ Roles\t: " . implode(', ', $customRoles));
        Log::info("\t+ IP\t: " . $request->ip());
        Log::info("\t+ Time\t: " . now()->toDateTimeString());

        return redirect('/admin');
    }

    public function logout(Request $request)
    {

        $user = Auth::user();
        Log::info('### SSO Logout ###');
        Log::info("\t+ Name\t: " . ($user->name ?? 'Unknown'));
        Log::info("\t+ IP\t: " . $request->ip());
        Log::info("\t+ Time\t: " . now()->toDateTimeString());


        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $keycloakBaseUrl = config('services.keycloak.base_url');
        $realm = config('services.keycloak.realms');
        $redirectUri = url('/');

        $logoutUrl = "{$keycloakBaseUrl}/realms/{$realm}/protocol/openid-connect/logout?post_logout_redirect_uri=".urlencode($redirectUri). "&client_id=" . config('services.keycloak.client_id');


        Auth::logout();

        return redirect($logoutUrl);
    }
}
