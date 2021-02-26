<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
	/**
	 * Get all articles.
	 *
	 * @return void
	 */
	public function test_get_all_articles()
	{
		$response = $this->getJson('/api/articles');

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'data' => [
					[
						'id',
						'title',
						'description',
						'image',
						'user' => [
							'name'
						],
						'category' => [
							'prefix',
							'color'
						],
						'comments',
						'createdAt',
					]
				],
				'links',
				'meta'
			]);
	}
}
