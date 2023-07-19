<?php

namespace App\Jobs;

use App\Models\Player;
use App\Notifications\MissedVocabulary;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PlayerMissedVocabularyProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dateLimit = Carbon::today()->subDays(3);
        $today = Carbon::today();
        
        $players = Player::where('last_game_at', '>=', $dateLimit)->get();
        
        foreach ($players as $key => $player) {
            $vocabularies = [];
            $quizzes = $player->quizzes->whereBetween('start_time', [$dateLimit, $today]);
            foreach($quizzes as $quiz){
                foreach($quiz->wrong_answers as $answers){
                    array_push($vocabularies, $answers->vocabulary->vocabulary);
                }
            }
            if($vocabularies){
                $player->notify(new MissedVocabulary($vocabularies));
            }
        }
    }
}
