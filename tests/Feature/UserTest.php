<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function testLogout()
    {
        $this->seed(UserSeeder::class);


        $response = $this->delete('/api/users', [
            'Authorization' => 'testToken',
        ]);

        dump($response->json());
        $response->assertStatus(401)->assertJson([
            "errors" => "Unauthorized.",
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function testUserLoginSuccess()
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/api/users', [
            'email' => 'admin@mail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)->assertJson([
            "message" => "Login successful",
        ]);
        dump($response->json());
    }

    public function testUserLoginFail()
    {
        $this->seed(UserSeeder::class);
        $response = $this->post('/api/users', [
            'email' => 'wrong@mail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(400)->assertJson([
            "errors" => "The provided credentials are incorrect."
        ]);
        dump($response->json());
    }

    public function testUserGet()
    {
        $this->seed(UserSeeder::class);


        $response = $this->get('/api/users', [
            'Authorization' => 'testToken',
        ]);

        dump($response->json());
        $response->assertStatus(200)->assertJson([
            "message" => "Get user success.",
        ]);
    }


}
