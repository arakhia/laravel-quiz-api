<?php

namespace Tests\Feature;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Vocabulary;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    private $quiz;
    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::factory()->hasPlayer()->create();
        Sanctum::actingAs($this->user, ['user']);

        Vocabulary::factory(5)->create(); // needed for quiz creation (random option)
        $this->quiz = Quiz::factory(['creation_type' => 'random'])->create();
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function get_quiz_list()
    {
        $this->user = User::factory()->hasPlayer()->create();
        Sanctum::actingAs($this->user, ['admin']); // this method only for admin

        $response = $this->getJson(route('quiz.index'))->assertOk();
        
        $this->assertEquals(1, count($response->json()['data']));
        $this->assertEquals($response->json()['data'][0]['id'], $this->quiz->id);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function show_quiz()
    {
        $this->withExceptionHandling();

        $response = $this->getJson(route('quiz.show', $this->quiz->id))->assertOk()->json();

        $this->assertEquals($response['data']['id'], $this->quiz->id);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function store_quiz()
    {
        
        $response = $this->postJson(route('quiz.store', [
            'name' => $this->quiz->name,
            'player_id' => $this->user->player->id,
            'creation_type' => $this->quiz->creation_type,
            'duration_in_seconds' => $this->quiz->duration_in_seconds,
            'start_time' => $this->quiz->start_time,
            'end_time' => $this->quiz->end_time,
            'result' => $this->quiz->result
        ]))->assertCreated();

        $this->assertDatabaseHas('quizzes', [
            'id' => $this->quiz->id,
            'name' => $this->quiz->name,
            'creation_type' => $this->quiz->creation_type,
            'duration_in_seconds' => $this->quiz->duration_in_seconds,
            'start_time' => $this->quiz->start_time,
            'end_time' => $this->quiz->end_time,
            'result' => $this->quiz->result
        ]);

        // ($this->quiz->id)+1 because this is the second item (the first in setUp method)
        $this->assertEquals($response['data']['id'], ($this->quiz->id)+1);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function validate_store_quiz()
    {
        $this->withExceptionHandling();

        $this->postJson(route('quiz.store'))->assertUnprocessable()
        ->assertJsonValidationErrors('creation_type');
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function update_quiz()
    {
        $response = $this->patchJson(route('quiz.update', $this->quiz->id), 
        [
            'name' => 'updated_name',
            'player_id' => $this->quiz->player_id,
            'creation_type' => $this->quiz->creation_type
        ]
        )->assertOk();

        $this->assertEquals($response['data']['name'], 'updated_name');
        
        $this->assertDatabaseHas('quizzes', ['id' => $this->quiz->id, 'name' => 'updated_name']);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function delete_quiz()
    {
        $this->deleteJson(route('quiz.destroy', $this->quiz->id))->assertNoContent();
        
        $this->assertDatabaseMissing('quizzes', ['id' => $this->quiz->id, 'creation_type' => $this->quiz->creation_type]);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function prevent_unauthorized_show_quiz()
    {
        $this->withExceptionHandling();

        $this->user = User::factory(['id' => 10])->hasPlayer()->create();
        Sanctum::actingAs($this->user, ['user']);

        $this->getJson(route('quiz.show', $this->quiz->id))->assertForbidden();
    }
}
