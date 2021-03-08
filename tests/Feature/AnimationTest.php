<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnimationTest extends TestCase
{
	/**
	 * Get all animations
	 *
	 * @return void
	 */
	public function test_get_all_animations()
	{
		$response = $this->get('/api/animations');

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'*' => [
					[
						'id',
						'name',
						'category',
						'target',
						'startAt',
						'finishAt'
					]
				]
			]);
	}
}
