<?php
namespace Tests\Unit\Repositories;

use App\Models\Admon\Role;
use App\Repositories\Eloquent\Admon\RoleRepository;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Services\Admon\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Mockery;
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
        // Creamos 5 roles usando factory
        Role::factory()->count(5)->create();

        // Creamos la colección de roles
        $rolesCollection = Role::all();  // Obtener los roles creados

        // Creamos un LengthAwarePaginator con la colección de roles
        $paginator = new LengthAwarePaginator(
            $rolesCollection->forPage(1, 2),  // Paginamos para la página 1, con 2 elementos por página
            $rolesCollection->count(),       // Total de elementos
            2,                               // Elementos por página
            1,                               // Página actual
            ['path' => url('/')]             // Path base para la paginación
        );

        // Mockear el RoleRepositoryInterface para devolver el LengthAwarePaginator
        $roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);
        $roleRepositoryMock
            ->shouldReceive('getAllPaginated')
            ->once()
            ->with([], 2)  // Se espera que reciba los filtros y el per_page
            ->andReturn($paginator);  // Aseguramos que devuelva un LengthAwarePaginator

        // Instanciamos el RoleService con el RoleRepositoryMock
        $roleService = new RoleService($roleRepositoryMock);

        $roles = $roleService->getAllPaginated([], 2);

        // Verificamos que el paginator devuelto tiene los valores correctos
        $this->assertEquals(2, $roles->perPage());  // Debe devolver 2 elementos por página
        $this->assertEquals(5, $roles->total());   // Debe devolver un total de 5 roles
        $this->assertEquals(3, $roles->lastPage()); // Debe haber 3 páginas (5 roles, 2 por página)
        $this->assertCount(2, $roles->items());    // En la página 1, debe devolver 2 elementos

        // Opcional: Verificar la existencia de las URLs de paginación
        $this->assertNotNull($roles->nextPageUrl());   // Debe existir una URL para la siguiente página
        $this->assertNull($roles->previousPageUrl()); // En la página 1, no debe haber una URL anterior
    }

    // Después de cada test, limpiamos los mocks
    public function tearDown(): void
    {
        Mockery::close();
    }
}
