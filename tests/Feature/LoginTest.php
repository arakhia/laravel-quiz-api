<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
    
    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function user_can_login()
    {
        $this->withExceptionHandling();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => $this->user->email
        ]);

        $response = $this->postJson(route('login.login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]))->assertOk()->json();
        
        $this->assertArrayHasKey("token", $response);
    }

    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function prevent_unauthorized_login()
    {
        $this->withExceptionHandling();

        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'email' => $this->user->email
        ]);

        $this->postJson(route('login.login', [
            'email' => 'wronge_email@example.example',
            'password' => 'password' // correct password from UserFactory.php
        ]))->assertUnauthorized();

        $this->postJson(route('login.login', [
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]))->assertUnauthorized();
    }
}
