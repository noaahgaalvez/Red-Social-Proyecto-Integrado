<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Publicacion;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Publicacion::query()->latest()->paginate(20);

        $users = User::query()->where('id', '!=', auth()->id())->get();

        return Inertia::render('Home', [
            'posts' => PostResource::collection($posts),
            'users' => UserResource::collection($users),
        ]);
    }
}
