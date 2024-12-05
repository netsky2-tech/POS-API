<?php

namespace Tests\Unit;

use App\Http\Controllers\V1\UserController;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testing register a new user.
     */
    public function test_user_can_be_created()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_get_all_users()
    {
        $userRepo = $this->createMock(UserRepositoryInterface::class);
        $userRepo->expects($this->once())
                 ->method('getAllUsers')
                 ->willReturn(collect(['user1','user2']));

        $controller = new UserController($userRepo);

        $response = $controller->index();
        $this->assertCount(2, $response->getData());
    }

}
