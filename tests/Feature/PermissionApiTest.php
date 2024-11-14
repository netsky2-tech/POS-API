<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admon\Role;
use App\Models\Admon\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionApiTest extends TestCase
{
    use RefreshDatabase;
/*
    public function test_admin_can_access_menu()
    {

        $role = RoleController::factory()->create(['name' => 'admin']);
        $menu = Menu::factory()->create(['name' => 'facturacion']);


        $user = User::factory()->create();
        $user->roles()->attach($role);
        $role->menus()->attach($menu);


        $this->actingAs($user);


        $response = $this->getJson('/api/menus/facturacion');


        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'facturacion']);
    }


    public function test_vendedor_cannot_access_admin_menu()
    {

        $role = RoleController::factory()->create(['name' => 'vendedor']);
        $menu = Menu::factory()->create(['name' => 'admin_menu']);


        $user = User::factory()->create();
        $user->roles()->attach($role);


        $this->actingAs($user);


        $response = $this->getJson('/api/menus/admin_menu');


        $response->assertStatus(403);
    }
        */
}
