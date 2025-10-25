<?php

use App\Http\Controllers\LandingController;
use App\Livewire\Backend\Admin;
use App\Livewire\Backend\Akses;
use App\Livewire\Backend\Menu;
use App\Livewire\Backend\Role;
use App\Livewire\Backend\User;
use Illuminate\Support\Facades\Route;

Route::any('/', [LandingController::class, 'landing'])->name('landing');
Route::any('/login', [LandingController::class, 'login'])->name('login');
Route::any('/logout', [LandingController::class, 'logout'])->name('logout');
Route::get('/admin', Admin::class);
Route::get('/akses', Akses::class);
Route::get('/menu', Menu::class);
Route::get('/role', Role::class);
Route::get('/user', User::class);
