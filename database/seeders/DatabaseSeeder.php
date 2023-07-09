<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        Player::factory(10)->create();
        Quiz::factory(5)->hasVocabularies(2)->create();
    }
}
