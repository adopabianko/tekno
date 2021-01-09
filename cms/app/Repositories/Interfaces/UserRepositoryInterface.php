<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface {
    public function findAll();
    public function findAllWithPaginate(string $role, string $name, string $email);
    public function save(array $userData);
    public function findRoleUser(int $userId);
    public function update(array $newUserData, User $oldUserData);
    public function destroy(int $id);
    public function profileUpdate(array $newUserData, User $oldUserData);
}
