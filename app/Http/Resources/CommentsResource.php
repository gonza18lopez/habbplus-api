<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
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
			'user' => [
				'id' => $this->user->id,
				'name' => $this->user->name,
				'figure' => $this->user->figure
			],
			'message' => $this->message,
			'createdAt' => $this->createdAt
		];
	}
}
