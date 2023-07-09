<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vocabulary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class VocabularyControllerTest extends TestCase
{
    use RefreshDatabase;

    private $vocabulary;

    public function setUp() :void
    {
        parent::setUp();

        $this->vocabulary = Vocabulary::factory()->create();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function get_vocabulary_list()
    {
        $response = $this->getJson(route('vocabulary.index'));
        
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals($response->json()['data'][0]['vocabulary'], $this->vocabulary->vocabulary);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function show_vocabulary()
    {
        $response = $this->getJson(route('vocabulary.show', $this->vocabulary->id))->assertOk()->json();

        $this->assertEquals($response['data']['vocabulary'], $this->vocabulary->vocabulary);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function store_vocabulary()
    {
        $response = $this->postJson(route('vocabulary.store', [
            'vocabulary' => $this->vocabulary->vocabulary,
            'complexity' => $this->vocabulary->complexity,
            'form' => $this->vocabulary->form,
            'field' => $this->vocabulary->field,
            'usage_count' => $this->vocabulary->usage_count,
            'success_count' => $this->vocabulary->success_count,
            'failure_count' => $this->vocabulary->failure_count
        ]))->assertCreated()->json();

        $this->assertDatabaseHas('vocabularies', [
            'id' => $this->vocabulary->id,
            'vocabulary' => $this->vocabulary->vocabulary,
            'complexity' => $this->vocabulary->complexity,
            'form' => $this->vocabulary->form,
            'field' => $this->vocabulary->field,
            'usage_count' => $this->vocabulary->usage_count,
            'success_count' => $this->vocabulary->success_count,
            'failure_count' => $this->vocabulary->failure_count
        ]);

        $this->assertEquals($response['data']['vocabulary'], $this->vocabulary->vocabulary);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function validate_store_vocabulary()
    {
        $this->withExceptionHandling();

        $this->postJson(route('vocabulary.store'))->assertUnprocessable()
        ->assertJsonValidationErrors('vocabulary')
        ->assertJsonValidationErrors('complexity');
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function update_vocabulary()
    {
        //$this->vocabulary->complexity = 'new_complexity';
        $response = $this->patchJson(route('vocabulary.update', $this->vocabulary->id), ['vocabulary' => $this->vocabulary->vocabulary,
        'complexity' => 'new_complexity'])->assertOk();

        $this->assertEquals($response['data']['complexity'], 'new_complexity');

        $this->assertDatabaseHas('vocabularies', ['id' => $this->vocabulary->id, 'complexity' => 'new_complexity']);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function delete_vocabulary()
    {
        $this->deleteJson(route('vocabulary.destroy', $this->vocabulary->id))->assertNoContent();
        
        $this->assertDatabaseMissing('vocabularies', ['id' => $this->vocabulary->id, 'vocabulary' => $this->vocabulary->vocabulary]);
    }

}
