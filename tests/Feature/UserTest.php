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


        $response = $this->withHeader('Authorization','testToken')->delete('/api/users');

        $user = User::where('email','admin@mail.com')->first();



        $response->assertStatus(200)->assertJson([
            "message" => "User logged out successfully.",
            "data" => null
        ]);

        self::assertNull($user->token);
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
        self::assertNotNull($response['data']['token']);

    }

    public function testUserLoginFailEmailAndPassword()
    {
        $this->seed(UserSeeder::class);
        $this->post('/api/users', [
            'email' => 'wrong@mail.com',
            'password' => 'password',
        ])->assertStatus(400)->assertJson([
            "errors" => "The provided credentials are incorrect."
        ]);

        $this->post('/api/users', [
            'email' => 'admin@mail.com',
            'password' => 'wrongpassword',
        ])->assertStatus(400)->assertJson([
            "errors" => "The provided credentials are incorrect."
        ]);
    }

    public function testUserGet()
    {
        $this->seed(UserSeeder::class);


        $response = $this->get('/api/users', [
            'Authorization' => 'testToken',
        ]);

        $response->assertStatus(200)->assertJson([
            "message" => "Get user success.",
            'data' => [
                'name' => 'admin',
                'email' => 'admin@mail.com'
            ]
        ]);
    }

    public function testAllProtectedUsersEndpointFailAuthError()
    {
        $this->seed(UserSeeder::class);
        $this->withHeader('Authorization','wrongToken')->get('/api/users')
            ->assertStatus(401)
            ->assertJson(["errors" => "Unauthorized."]);

        $this->withHeader('Authorization','wrongToken')->delete('/api/users')
            ->assertStatus(401)
            ->assertJson(["errors" => "Unauthorized."]);;
    }
}
