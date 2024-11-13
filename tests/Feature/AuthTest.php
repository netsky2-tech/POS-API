<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                    'message' => 'Usuario creado con éxito.',
                ]);
    }

    /** @test */
    public function test_user_can_login_and_receive_jwt_token()
    {
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('password')
        ]);


        $response = $this->postJson('/api/login', [
            'email' => 'testuser@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'access_token',
                    'token_type'
                ]);
    }

    public function test_authenticated_user_can_access_me()
    {

        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->getJson('/api/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'email' => $user->email,
                     'name' => $user->name,
                 ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);


        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Sesión cerrada correctamente']);
    }

    public function test_access_without_token()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }
}
