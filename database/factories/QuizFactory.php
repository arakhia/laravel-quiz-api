<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$users = User::pluck('id')->toArray();
        $players = Player::pluck('id')->toArray();
        $start_time = $this->faker->dateTimeBetween('-15 mins', '+15 mins');
        $end_time = $this->faker->dateTimeBetween($start_time, '+15 mins');
        return [
            'name' => $this->faker->text(20),
            'player_id' => $this->faker->randomElement($players),
            'creation_type' => $this->faker->randomElement(['random', 'selected']),
            'duration_in_seconds' => $this->faker->numberBetween(10, 600),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'result' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
