<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$users = User::pluck('id')->toArray();
        //dd($users);
        $last_game_at = $this->faker->dateTimeBetween('-15 mins', '+15 mins');
        return [
            'name' => $this->faker->text(20),
            'user_id' => User::factory(),
            'games_count' => $this->faker->numberBetween(10, 600),
            'last_game_at' => $last_game_at,
            'score' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
