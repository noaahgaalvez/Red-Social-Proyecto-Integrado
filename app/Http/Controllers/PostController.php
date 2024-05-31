<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        Publicacion::create($data);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Publicacion $publicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publicacion $publicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Publicacion $post)
    {
        $post->update($request->validated());
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publicacion $post)
    {
        $id = Auth::id();

        if ($post->user_id === $id) {
            $post->delete();
        }

        return back();
    }
}
