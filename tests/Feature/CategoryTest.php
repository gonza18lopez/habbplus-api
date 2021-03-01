<?php

namespace Tests\Feature;

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
                'id',
                'name',
                'color',
                'prefix'
            ]);
    }
}
