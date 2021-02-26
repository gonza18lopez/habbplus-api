<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

	/**
	 * Test if user without permissions, can't create an article
	 * 
	 * @return void
	 */
	public function test_user_cant_create_article()
	{
		Storage::fake('thumbnails');

		$user = User::factory()->create();
		$category = Category::factory()->create();
		$file = UploadedFile::fake()->image('thumnail.jpg');

		$response = $this->actingAs($user, 'api')->postJson('/api/articles', [
			'title' => 'Testing Title',
			'description' => 'Sit et quas eligendi. At reprehenderit voluptas iste impedit. Libero maxime facilis blanditiis et id. Illo quae quis officiis ipsum vero vero consequatur hic. Mollitia animi explicabo sit qui tempore.',
			'body' => 'Eos adipisci quis earum est. Veritatis impedit porro temporibus aperiam doloremque et. Aliquam quis ut est. Minus ipsum repellat ducimus dolores consequuntur repellendus earum. Omnis quidem voluptatem eum quo ut. Voluptatem soluta veritatis omnis quia optio. Aut magni praesentium atque minus. Est sit facilis magni et dolorum distinctio. Fuga consectetur perspiciatis voluptatibus. Consectetur eius perspiciatis vitae fugit omnis aut. Libero ea illum atque aut. Accusantium alias eaque omnis id quae voluptatem quisquam. Eos labore sunt voluptate id. Ut hic voluptas est omnis pariatur corporis et. Sit autem aliquam ducimus alias exercitationem iusto. Officia modi accusantium voluptas necessitatibus quis est eos. Et reprehenderit dolorem enim. Placeat voluptatem et odit.',
			'image' => $file,
			'category' => $category->id
		]);

		$response
			->assertStatus(403);
	}
}
