<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class ArticleTest extends TestCase
{
	protected $baseUrl = 'http://habbplus.test';

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
		$response = $this->getJson("/api/articles/1");

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'id',
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

		Sanctum::actingAs($user);

		$response = $this->postJson('/api/articles', [
			'title' => 'Testing Title',
			'description' => 'Sit et quas eligendi. At reprehenderit voluptas iste impedit. Libero maxime facilis blanditiis et id. Illo quae quis officiis ipsum vero vero consequatur hic. Mollitia animi explicabo sit qui tempore.',
			'body' => 'Eos adipisci quis earum est. Veritatis impedit porro temporibus aperiam doloremque et. Aliquam quis ut est. Minus ipsum repellat ducimus dolores consequuntur repellendus earum. Omnis quidem voluptatem eum quo ut. Voluptatem soluta veritatis omnis quia optio. Aut magni praesentium atque minus. Est sit facilis magni et dolorum distinctio. Fuga consectetur perspiciatis voluptatibus. Consectetur eius perspiciatis vitae fugit omnis aut. Libero ea illum atque aut. Accusantium alias eaque omnis id quae voluptatem quisquam. Eos labore sunt voluptate id. Ut hic voluptas est omnis pariatur corporis et. Sit autem aliquam ducimus alias exercitationem iusto. Officia modi accusantium voluptas necessitatibus quis est eos. Et reprehenderit dolorem enim. Placeat voluptatem et odit.',
			'image' => $file,
			'category' => $category->id
		]);

		$response
			->assertStatus(403);
	}

	/**
	 * Test if user with permissions can create an article
	 * 
	 * @return void
	 */
	public function test_user_can_create_article()
	{
		Storage::fake('thumbnails');

		// create entities
		$user = User::factory()->create();
		$category = Category::factory()->create();
		$file = UploadedFile::fake()->image('thumnail-' . Str::random(25) . '.jpg');

		// assign user permissions
		$user->assignRole('journalists managers');

		Sanctum::actingAs($user);

		$response = $this->postJson('/api/articles', [
			'title' => 'Testing Title',
			'description' => 'Sit et quas eligendi. At reprehenderit voluptas iste impedit. Libero maxime facilis blanditiis et id. Illo quae quis officiis ipsum vero vero consequatur hic. Mollitia animi explicabo sit qui tempore.',
			'body' => 'Eos adipisci quis earum est. Veritatis impedit porro temporibus aperiam doloremque et. Aliquam quis ut est. Minus ipsum repellat ducimus dolores consequuntur repellendus earum. Omnis quidem voluptatem eum quo ut. Voluptatem soluta veritatis omnis quia optio. Aut magni praesentium atque minus. Est sit facilis magni et dolorum distinctio. Fuga consectetur perspiciatis voluptatibus. Consectetur eius perspiciatis vitae fugit omnis aut. Libero ea illum atque aut. Accusantium alias eaque omnis id quae voluptatem quisquam. Eos labore sunt voluptate id. Ut hic voluptas est omnis pariatur corporis et. Sit autem aliquam ducimus alias exercitationem iusto. Officia modi accusantium voluptas necessitatibus quis est eos. Et reprehenderit dolorem enim. Placeat voluptatem et odit.',
			'image' => $file,
			'category' => $category->id
		]);

		$response
			->assertStatus(201)
			->assertJsonStructure([
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
			]);
	}

	/**
	 * Test if user without permissions can't update an article
	 * 
	 * @return void
	 */
	public function test_user_cant_update_article()
	{
		Storage::fake('thumbnails');

		// create entities
		$user = User::factory()->create();
		$article = Article::factory()->create();
		$file = UploadedFile::fake()->image('thumnail-' . Str::random(25) . '.jpg');

		Sanctum::actingAs($user);

		$response = $this->patchJson("/api/articles/{$article->id}", [
			'title' => 'New title',
			'description' => 'New description'
		]);

		$response
			->assertStatus(403);
	}

	/**
	 * Test if user can update an article
	 * 
	 * @return void
	 */
	public function test_user_can_update_article()
	{
		Storage::fake('thumbnails');

		$data = [
			'title' => 'New title',
			'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit.'
		];

		// create entities
		$user = User::factory()->create();
		$article = Article::factory()->create();
		$file = UploadedFile::fake()->image('thumnail-' . Str::random(25) . '.jpg');

		// assign user permissions
		$user->assignRole('journalists managers');

		Sanctum::actingAs($user);

		$response = $this->patchJson("/api/articles/{$article->id}", $data);

		$response
			->assertOk()
			->assertJson($data);
	}

	/**
	 * Test if user cant delete article
	 * 
	 * @return void
	 */
	public function test_user_cant_delete_article()
	{
		// create entities
		$user = User::factory()->create();
		$article = Article::factory()->create();

		Sanctum::actingAs($user);

		$response = $this->deleteJson("/api/articles/{$article->id}");

		$response
			->assertStatus(403);
	}

	/**
	 * Test if user can delete article
	 * 
	 * @return void
	 */
	public function test_user_can_delete_article()
	{
		// create entities
		$user = User::factory()->create();
		$article = Article::factory()->create();

		// assign user permissions
		$user->assignRole('journalists managers');

		Sanctum::actingAs($user);

		$response = $this->deleteJson("/api/articles/{$article->id}");

		$response
			->assertOk()
			->assertJson([
				'deleted' => true
			]);
	}
}
