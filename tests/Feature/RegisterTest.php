<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    
    /** 
     * A basic feature test example.
     * @test
     * @return void
     */
    public function user_can_register()
    {
        $this->withExceptionHandling();

        $response = $this->postJson(route('register.register', [
            'name' => 'test1234',
            'email' => 'test1234@test.tset',
            'password' => 'test1234',
            'password_confirmation' => 'test1234'
        ]))->assertCreated()->json();
        
        $this->assertDatabaseHas('users', [
            'name' => 'test1234',
            'email' => 'test1234@test.tset'
        ]);
    }
}
