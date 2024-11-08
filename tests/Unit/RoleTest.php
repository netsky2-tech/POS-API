<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admon\Role;
use App\Models\Admon\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing a rol have permission
     */
    public function test_role_can_have_permissions()
    {

        $role = Role::factory()->create(['name' => 'vendedor']);
        $permission = Permission::factory()->create(['role_id' => $role->id]);

        $role->permissions()->attach($permission);

        $this->assertTrue($role->permissions->contains($permission));
    }
}
