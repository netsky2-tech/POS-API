<?php

namespace Controllers\V1;

use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\HandlesAuthCookies;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase, HandlesAuthCookies;

    /**
     * Test de inicio de sesión de usuario.
     *
     * @return void
     */
    public function testLogin()
    {
        // Crear un usuario para hacer login
        $user = User::factory()->create([
            'password' => 'password123'
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'token',
            ]);
    }

    /**
     * Test de inicio de sesión con credenciales incorrectas.
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Credenciales incorrectas',
            ]);
    }

    public function testRegister()
    {
        $company = Company::factory()->create();
        $branch = Branch::factory()->create(['company_id' => $company->id]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'full_name' => 'Juan Pérez Gonzales',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'company_id' => $company->id,
            'branch_id' => $branch->id,
            'created_by' => 'admin'
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Usuario creado con éxito.',
            ]);
    }

    /**
     * Test para obtener los datos del usuario autenticado.
     *
     * @return void
     */
    public function testGetUser()
    {

        $user = User::factory()->create();

        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/auth/user');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }
    public function test_access_without_token()
    {
        $response = $this->getJson('/api/v1/auth/user');

        $response->assertStatus(401)
                 ->assertJson(["message" => "Token not provided"]);
    }
    /**
     * Test de cerrar sesión de usuario.
     *
     * @return void
     */
    public function testLogout()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Sesión cerrada correctamente',
            ]);
    }

    /**
     * Test de refresco de token JWT.
     *
     * @return void
     */
    public function testRefresh()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/refresh');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token',
            ]);
    }
}
