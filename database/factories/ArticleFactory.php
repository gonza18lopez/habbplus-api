<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(7),
            'image' => 'storage/thumbnails/vsDgzhEYDwbmmqv8YYn9tYOYjpj0g9cyeoSawRI0.png',
            'body' => $this->faker->paragraph(20),
            'status' => 1,
            'moderated_at' => Carbon::now(),
            'moderated_by' => 1
        ];
    }
}
