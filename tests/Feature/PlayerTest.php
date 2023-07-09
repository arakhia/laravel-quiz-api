<?php

namespace Tests\Feature;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    private $player;
    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->player = Player::factory()->create();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function get_player_list()
    {
        $response = $this->getJson(route('player.index'))->assertOk();
        
        $this->assertEquals(1, count($response->json()));
        $this->assertEquals($response->json()['data'][0]['id'], $this->player->id);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function show_player()
    {
        $this->withExceptionHandling();

        $response = $this->getJson(route('player.show', $this->player->id))->assertOk()->json();
        
        $this->assertEquals($response['data']['id'], $this->player->id);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function store_player()
    {
        $response = $this->postJson(route('player.store', [
            'name' => $this->player->name,
            'user_id' => $this->user->id,
            'score' => $this->player->score,
            'last_game_at' => $this->player->last_game_at,
            'games_count' => $this->player->games_count
        ]))->assertCreated()->json();

        $this->assertDatabaseHas('players', [
            'id' => $this->player->id,
            'name' => $this->player->name,
            'score' => $this->player->score,
            'last_game_at' => $this->player->last_game_at,
            'games_count' => $this->player->games_count
        ]);

        // ($this->player->id)+1 because this is the second item (the first in setUp method)
        $this->assertEquals($response['data']['id'], ($this->player->id)+1);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function validate_store_player()
    {
        $this->withExceptionHandling();
        
        $this->postJson(route('player.store'))->assertUnprocessable()
        ->assertJsonValidationErrors('user_id');
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function update_player()
    {
        //$this->vocabulary->complexity = 'new_complexity';
        //dd($this->player);
        $response = $this->patchJson(route('player.update', $this->player->id), ['name' => 'updated_name',
        'user_id' => $this->player->user_id])->assertOk();
        
        $this->assertEquals($response['data']['name'], 'updated_name');
        
        $this->assertDatabaseHas('players', ['id' => $this->player->id, 'name' => 'updated_name']);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function delete_player()
    {
        $this->deleteJson(route('player.destroy', $this->player->id))->assertNoContent();
        
        $this->assertDatabaseMissing('players', ['id' => $this->player->id, 'user_id' => $this->player->user_id]);
    }
}
