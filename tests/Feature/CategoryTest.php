<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
	/**
	 * Get all categories availables.
	 *
	 * @return void
	 */
	public function test_get_all_categories()
	{
		$response = $this->getJson('/api/categories');

		$response
			->assertStatus(200)
			->assertJsonStructure([
				[
					'id',
					'name',
					'meta' => [
						'color',
						'prefix'
					]
				]
			]);
	}

	/**
	 * Get all child articles of a category.
	 *
	 * @return void
	 */
	public function test_show_category()
	{
		$response = $this->getJson('/api/categories/1');

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
	 * Test if guest can't create category
	 */
	public function test_guest_cant_create_category()
	{
		$response = $this->postJson('/api/categories');

		$response
			->assertStatus(401);
	}

	/**
	 * Test if user can't create category
	 * 
	 * @return void
	 */
	public function test_user_cant_create_category()
	{
		// create fake user
		$user = User::factory()->create();

		// Log-in fake user
		Sanctum::actingAs($user);

		// try create category
		$response = $this->postJson('/api/categories');

		// assert results
		$response
			->assertStatus(403);
	}

	/**
	 * Test if user can create category
	 * 
	 * @return void
	*/
	public function test_user_can_create_category()
	{
		// create fake user
		$user = User::factory()->create();

		// assign role
		$user->assignRole('journalists managers');

		// Log-in fake user
		Sanctum::actingAs($user);

		// try create category
		$response = $this->postJson('/api/categories', [
			'name' => 'PHPUnit Category',
			'prefix' => 'PC',
			'color' => 'green'
		]);

		// assert results
		$response
			->assertStatus(201)
			->assertJsonStructure([
				'id',
				'name',
				'meta' => [
					'prefix',
					'color'
				]
			]);
	}

	/**
	 * Test user cant update category
	 * 
	 * @return void
	 */
	public function test_user_cant_update_category()
	{
		// create fake user
		$user = User::factory()->create();

		// Log-in fake user
		Sanctum::actingAs($user);

		// try create category
		$response = $this->patchJson('/api/categories/1');

		// assert results
		$response
			->assertStatus(403);
	}

	/**
	 * Test user can update category
	 * 
	 * @return void
	 */
	public function test_user_can_update_category()
	{
		// create fake user
		$user = User::factory()->create();

		// assign role
		$user->assignRole('journalists managers');

		// Log-in fake user
		Sanctum::actingAs($user);

		// try create category
		$response = $this->patchJson('/api/categories/1', [
			'name' => 'Update PHPUnit'
		]);

		// assert results
		$response
			->assertStatus(200);
	}

	/**
	 * Test user cant delete category
	 * 
	 * @return void
	 */
	public function test_user_cant_delete_category()
	{
		// create fake category
		$category = Category::factory()->create();

		// create fake user
		$user = User::factory()->create();

		// Log-in fake user
		Sanctum::actingAs($user);

		// try create category
		$response = $this->deleteJson('/api/categories/1');

		// assert results
		$response
			->assertStatus(403);
	}

	/**
	 * Test user can delete category
	 * 
	 * @return void
	 */
	public function test_user_can_delete_category()
	{
		// create fake category
		$category = Category::factory()->create();

		// create fake user
		$user = User::factory()->create();

		// assign role
		$user->assignRole('journalists managers');

		// Log-in fake user
		Sanctum::actingAs($user);

		// try create category
		$response = $this->deleteJson("/api/categories/{$category->id}");

		// assert results
		$response
			->assertNoContent();
	}
}
