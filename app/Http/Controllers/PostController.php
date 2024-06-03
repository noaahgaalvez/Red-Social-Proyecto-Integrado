<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\AdjuntoPublicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $user = $request->user();

        DB::beginTransaction();
        $allAttachmentsPaths = [];
        try {
            $publicacion = Publicacion::create($data);
    
            $attachments = $data['attachments'] ?? [];
            foreach ($attachments as $attachment) {
                $path = $attachment->store('attachments/' . $publicacion->id, 'public');
                $allAttachmentsPaths[] = $path;
                AdjuntoPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'name' => $attachment->getClientOriginalName(),
                    'path' => $path,
                    'image' => $attachment->getMimeType(),
                    'tamanio' => $attachment->getSize(),
                    'created_by' => $user->id,
                ]);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            foreach ($allAttachmentsPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }

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
        $user = $request->user();
        
        DB::beginTransaction();
        $allAttachmentsPaths = [];
        try {
            $data = $request->validated();
            $post->update($data);

            $deletedAttachments = $data['deleteAttachments'] ?? [];
    
            $filesDeleted = AdjuntoPublicacion::query()
                ->where('publicacion_id', $post->id)
                ->whereIn('id', $deletedAttachments)
                ->get();

            foreach ($filesDeleted as $file) {
                $file->delete();
            }

            $attachments = $data['attachments'] ?? [];
            foreach ($attachments as $attachment) {
                $path = $attachment->store('attachments/' . $post->id, 'public');
                $allAttachmentsPaths[] = $path;
                AdjuntoPublicacion::create([
                    'publicacion_id' => $post->id,
                    'name' => $attachment->getClientOriginalName(),
                    'path' => $path,
                    'image' => $attachment->getMimeType(),
                    'tamanio' => $attachment->getSize(),
                    'created_by' => $user->id,
                ]);
            }
            
            DB::commit();
        } catch (\Exception $e) {
            foreach ($allAttachmentsPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            DB::rollBack();
            throw $e;
        }

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
