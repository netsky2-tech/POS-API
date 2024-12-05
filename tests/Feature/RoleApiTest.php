<?php

namespace Tests\Feature;

use App\Models\Admon\Role;
use App\Models\User;
use App\Services\Admon\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleApiTest extends TestCase
{
    use RefreshDatabase;

    protected mixed $roleService;

    public function setUp(): void
    {
        parent::setUp();
        $this->roleService = $this->app->make(RoleService::class);
    }

    public function test_can_create_role()
    {

        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/roles/create', [
                'name' => 'Admin',
                'created_by' => $user->name,
        ]);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'Admin',
        ]);
    }

    public function test_can_get_role_by_id()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson("/api/roles/show/{$role->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $role->id,
                    'name' => $role->name,
                ],
            ]);
    }

    public function test_can_delete_role()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson("/api/roles/delete/{$role->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Rol eliminado correctamente.',
            ]);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
        ]);
    }

    public function test_create_role_validation_fails()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/roles/create', [

        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_update_role_validation_fails()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson("/api/roles/update/{$role->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_roles_pagination()
    {
        // Crear un usuario para autenticarse
        $user = User::factory()->create();

        // Obtener un token para autenticar al usuario
        $token = auth()->login($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/roles/index', ['per_page' => 10]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'created_at', 'updated_at']
                ],
                'meta' => ['current_page', 'total', 'per_page', 'total_pages'],
                'links' => ['first', 'last', 'prev', 'next']
            ]);
    }
}
