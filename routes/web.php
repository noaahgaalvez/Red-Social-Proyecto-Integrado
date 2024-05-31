<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/auth.php';


Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/{user:username}', [ProfileController::class, 'index'])->name('profile');

Route::middleware('auth')->group(function () {
	Route::post('/profile/actualizarImagen', [ProfileController::class, 'actualizarImagen'])
		->name('profile.actualizarImagen');
		
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::post('/post', [PostController::class, 'store'])->name('post.create');
	Route::put('/{post}', [PostController::class, 'update'])->name('post.update');
	Route::delete('/{post}', [PostController::class, 'destroy'])->name('post.destroy');
});
