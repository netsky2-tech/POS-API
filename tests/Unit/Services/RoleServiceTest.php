<?php
namespace Tests\Unit\Services;

use App\Models\Admon\Role;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use App\Services\Admon\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    use refreshDatabase;

    protected RoleRepositoryInterface $roleRepositoryMock;
    protected RoleService $roleService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->roleRepositoryMock = Mockery::mock(RoleRepositoryInterface::class);
        $this->roleService = new RoleService($this->roleRepositoryMock);
    }

    public function test_get_all_roles()
    {
        $this->roleRepositoryMock
            ->shouldReceive('getAllPaginated')
            ->once()
            ->andReturn(collect([]));

        $result = $this->roleService->getAllPaginated([], 15);

        $this->assertEmpty($result);
    }

    public function test_create_role()
    {
        $data = [
            'name' => 'Admin',
            'created_by' => 'user'
        ];

        $this->roleRepositoryMock
            ->shouldReceive('createRole')
            ->once()
            ->with($data)
            ->andReturn(new Role($data));

        $result = $this->roleService->createRole($data);

        $this->assertInstanceOf(Role::class, $result);
        $this->assertEquals('Admin', $result->name);
    }
}
