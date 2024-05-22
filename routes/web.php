<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';


Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/{user:username}', [ProfileController::class, 'index'])->name('profile');
