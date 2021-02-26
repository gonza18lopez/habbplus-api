<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'body' => $this->body,
            'category' => [
                'name' => $this->category->name,
                'prefix' => $this->category->prefix,
                'color' => $this->category->color
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'figure' => $this->user->figure
            ],
            'comments' => CommentsResource::collection($this->comments()->with('user')->orderBy('id', 'desc')->get()),
            'createdAt' => $this->created_at->timestamp
        ];
    }
}
