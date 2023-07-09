<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VocabularyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vocabulary' => $this->faker->word,
            'complexity' => $this->faker->randomElement(['easy', 'medium', 'hard']),
            'form' => $this->faker->word,
            'field' => $this->faker->word,
            'usage_count' => 100,
            'success_count' => 70,
            'failure_count' => 30
        ];
    }
}
