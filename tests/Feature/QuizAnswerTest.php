<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuizAnswerTest extends TestCase
{
    use RefreshDatabase;
    
    private $vocabulary;
    private $quiz;
    private $answer;
    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::factory()->hasPlayer()->create();
        Sanctum::actingAs($this->user);

        //$this->answer = QuizAnswer::factory()->create();
        //$this->quiz = Quiz::factory()->hasAnswers(2)->hasVocabulary()->create();
        //$this->quiz = Quiz::factory()->hasAnswers(2)->create();
        //$this->quiz = Quiz::factory()->hasVocabularies(2)->create();
        $this->vocabulary = Vocabulary::factory()->create();
        $this->quiz = Quiz::factory()->create();
        $this->answer = QuizAnswer::factory([
            'quiz_id' => $this->quiz->id,
            'vocabulary_id' => $this->vocabulary->id
        ])->create();
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function show_quiz_answers()
    {
        $this->withExceptionHandling();

        $response = $this->getJson(route('quiz-answer.show', $this->answer->id))->assertOk()->json();
        
        $this->assertEquals($response['data']['id'], $this->answer->id);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function update_quiz_answers()
    {
        $response = $this->patchJson(route('quiz-answer.update', $this->answer->id), 
        [
            'answer' => 'player_answer',
            'duration_in_seconds' => 30
            
        ]
        )->assertOk();
        
        $this->assertEquals($response['data']['answer'], 'player_answer');
        
        $this->assertDatabaseHas('quiz_answers', ['id' => $this->answer->id, 'answer' => 'player_answer']);
    }

}
