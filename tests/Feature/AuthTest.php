<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Company;
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
        $company = Company::factory()->create();
        $branch = Branch::factory()->create(['company_id' => $company->id]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'company_id' => $company->id,
            'branch_id' => $branch->id
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


        $response = $this->postJson('/api/auth/login', [
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

        $response = $this->getJson('/api/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $user->id,
                     'email' => $user->email,
                     'name' => $user->name,
                     'company_id' => $user->company_id,
                     'branch_id' => $user->branch_id,
                 ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123')
        ]);


        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Sesión cerrada correctamente']);
    }

    public function test_access_without_token()
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }
}
