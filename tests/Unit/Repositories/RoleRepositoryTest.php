<?php
namespace Tests\Unit\Repositories;

use App\Models\Admon\Role;
use App\Repositories\Eloquent\Admon\RoleRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected RoleRepository $roleRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->roleRepository = new RoleRepository(new Role());
    }

    public function test_create_role()
    {
        $data = [
            'name' => 'Admon',
            'created_by' => 'user1'
        ];

        $role = $this->roleRepository->createRole($data);

        $this->assertDatabaseHas('roles', $data);
        $this->assertInstanceOf(Role::class, $role);
    }

    public function test_get_all_paginated()
    {
        Role::factory()->count(5)->create();

        $roles = $this->roleRepository->getAllPaginated([], 2);

        $this->assertEquals(2, $roles->perPage());
        $this->assertEquals(5, $roles->total());
    }
}
