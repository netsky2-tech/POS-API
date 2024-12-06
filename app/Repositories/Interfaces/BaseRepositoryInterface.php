<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function findUserById($id);
    public function createUser(array $data) : User;
    public function updateUser($id, array $data);
    public function deleteUser($id);

    public function findByEmail(string $email) : ?User;
}
