<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function findUserById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
}
