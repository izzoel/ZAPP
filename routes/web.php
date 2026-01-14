<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\sso\KeycloakController;
use App\Livewire\Backend\Admin;
use App\Livewire\Backend\Akses;
use App\Livewire\Backend\Icon;
use App\Livewire\Backend\Menu;
use App\Livewire\Backend\Role;
use App\Livewire\Backend\User;
use Illuminate\Support\Facades\Route;

Route::any('/', [LandingController::class, 'landing'])->name('landing');

// Login
Route::any('/login', [LandingController::class, 'login'])->name('login');

// Login SSO Keycloak
Route::get('/auth/redirect', [KeycloakController::class, 'redirect'])->name('sso.redirect');
Route::get('/auth/callback', [KeycloakController::class, 'callback'])->name('sso.callback');
Route::get('/auth/logout', [KeycloakController::class, 'logout'])->name('sso.logout');
Route::get('/auth/logged-out', [KeycloakController::class, 'loggedOut']);
Route::get('/auth/server/cek', [KeycloakController::class, 'cekServer']);

Route::middleware(['sso.auth'])->group(function () {
    Route::get('/admin', Admin::class);
    Route::get('/icon', Icon::class);
    Route::middleware(['read'])->group(function () {
        Route::get('/akses', Akses::class);
        Route::get('/menu', Menu::class);
        Route::get('/role', Role::class);
        Route::get('/user', User::class);
    });

    // =Dynamic Routes=
});

