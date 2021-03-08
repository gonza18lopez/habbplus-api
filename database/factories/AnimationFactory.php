<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Animation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AnimationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Animation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->sentence(3),
            'start_at' => Carbon::now(),
            'finish_at' => Carbon::now()->add(1, 'hour')
        ];
    }
}
