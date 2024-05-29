<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Publicacion::query()->latest()->paginate(20);

        return Inertia::render('Home', [
            'posts' => PostResource::collection($posts),
        ]);
    }
}
