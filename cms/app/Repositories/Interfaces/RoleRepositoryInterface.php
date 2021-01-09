<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;

interface RoleRepositoryInterface {
    public function findAll();
    public function findAllWithPaginate(string $name, string $displayName);
    public function save(array $roleData);
    public function findById(int $id);
    public function update(array $newRoleData, Role $oldRoleData);
}
