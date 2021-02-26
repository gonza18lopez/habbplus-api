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

	/**
	 * Get a single article
	 * 
	 * @return void
	 */
	public function test_get_single_article()
	{
		$response = $this->getJson('/api/articles/1');

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'title',
				'image',
				'body',
				'category' => [
					'name',
					'prefix',
					'color'
				],
				'user' => [
					'id',
					'name',
					'figure'
				],
				'comments' => [
					[
						'id',
						'user' => [
							'id',
							'name',
							'figure'
						],
						'message',
						'createdAt'
					]
				],
				'createdAt'
			]);
	}
}
