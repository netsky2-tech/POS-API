<?php

namespace Controllers\V1;

use App\Models\Admon\Role;
use App\Models\User;
use App\Services\Admon\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleApiTest extends TestCase
{
    use RefreshDatabase, withFaker;
    public function test_can_get_roles_paginated()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        Role::factory()->count(5)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson(route('v1.roles.index', ['par_page' => 2]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'created_at', 'updated_at'],
                ],
                'meta',
                'links',
            ]);
    }

    public function test_can_create_role()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $data = [
            'name' => 'Admin',
            'created_by' => $user->name
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson(route('v1.roles.store'), $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'name', 'created_at', 'updated_at']]);

        $this->assertDatabaseHas('roles', $data);
    }

    public function test_can_update_role()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $role = Role::factory()->create([
            'created_by' => 'Josianne Graham'
        ]);

        $updateData = ['name' => 'Updated Role'];

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson(route('v1.roles.update', $role), $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $role->id,
                    'name' => 'Updated Role',
                    'created_by' => 'Josianne Graham'
                ]
            ]);

        $this->assertDatabaseHas('roles', $updateData);
    }

    public function test_can_delete_role()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson(route('v1.roles.delete', $role));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
