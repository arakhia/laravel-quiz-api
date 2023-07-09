<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quizzes = Quiz::pluck('id')->toArray();
        $vocabularies = Vocabulary::pluck('id')->toArray();
        return [
            'quiz_id' => $this->faker->randomElement($quizzes),
            'vocabulary_id' => $this->faker->randomElement($vocabularies)
        ];
    }
}
