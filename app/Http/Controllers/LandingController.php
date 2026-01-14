<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    function landing()
    {
        return view('guest.landing');
    }

    function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
             session(['login_via' => 'form']);

            return response()->json(['success' => true, 'message' => 'Sukses']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal']);
        }
    }

    function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('landing');
    }
}
