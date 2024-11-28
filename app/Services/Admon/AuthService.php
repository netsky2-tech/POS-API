<?php

namespace App\Services\Admon;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data): User
    {
        return $this->userRepo->createUser($data);
    }

    /**
     * @throws \Exception
     */
    public function login(array $credentials, $ip)
    {
        $attempts = Cache::get('login_attempts_' . $ip, 0);

        if ($attempts >= 5) {
            throw new \Exception('Demasiados intentos. Inténtalo de nuevo en 10 minutos.');
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            Cache::increment('login_attempts_' . $ip);
            throw new \Exception('Credenciales incorrectas');
        }

        Cache::forget('login_attempts_' . $ip);

        return $token;
    }

    public function refreshToken($refreshToken)
    {
        return JWTAuth::refresh($refreshToken);
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function getUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $user = auth()->user();
        if ($user) {
            /**@var User | null $user */
            return $user->load('roles');
        }
    }
}
