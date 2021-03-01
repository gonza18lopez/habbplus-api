<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllArticlesResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $this->description,
			'image' => asset($this->image),
			'user' => [
				'name' => $this->user->name
			],
			'category' => [
				'prefix' => $this->category->prefix,
				'color' => $this->category->color
			],
			'comments' => $this->comments->count(),
			'createdAt' => $this->created_at->timestamp
		];
	}
}
