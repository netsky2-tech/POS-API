<?php

namespace Tests\Feature;

use App\Models\Admon\Role;
use App\Services\Admon\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleApiTest extends TestCase
{
    use RefreshDatabase;

    protected $roleService;

    public function setUp(): void
    {
        parent::setUp();
        $this->roleService = $this->app->make(RoleService::class);
    }

    public function test_can_create_role()
    {
        $response = $this->postJson('/api/roles/create', [
            'name' => 'Admin',
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
        $role = Role::factory()->create();

        $response = $this->getJson("/api/roles/show/{$role->id}");

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
        $role = Role::factory()->create();

        $response = $this->deleteJson("/api/roles/delete/{$role->id}");

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
        $response = $this->postJson('/api/roles/create', [

        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_update_role_validation_fails()
    {
        $role = Role::factory()->create();

        $response = $this->putJson("/api/roles/update/{$role->id}", [
            'name' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_roles_pagination()
    {
        $response = $this->getJson( '/api/roles/index', ['per_page' => 10]);

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
