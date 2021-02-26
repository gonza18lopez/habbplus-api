<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'image' => 'http://habbplus.fr/storage/thumbnails/post/2UDyHNa9Wtc6V3crZPVruiRo9JvtIWvXlC0ktcJh.png',
            'body' => $this->faker->paragraph
        ];
    }
}
