<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => new UserResource($this->user),
            'attachments' => AdjuntoPublicacionResource::collection($this->attachments),
            'reactions' => $this->reactions->count(),
            'user_reaction' => $this->reactions->count() > 0,
            'num_comments' => $this->comments->count(),
            'comments' => CommentResource::collection($this->comments),
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i'),
        ];
    }
}
