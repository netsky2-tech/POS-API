<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admon\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function test_get_all_users()
    {
        $userRepo = \Mockery::mock(UserRepositoryInterface::class);
        $userRepo->shouldReceive('getAllUsers')->once()->andReturn(collect(['user1', 'user2']));
        $controller = new UserController($userRepo);

        $response = $controller->index();
        $this->assertCount(2, $response->getData());
    }

}
