<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleAnimationsResource extends JsonResource
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
			'name' => $this->name,
			'target' => $this->animatable_id,
			'category' => $this->animatable_type,
			'startAt' => $this->start_at->format('h:i'),
			'finishAt' => $this->finish_at->format('h:i')
		];
	}
}
