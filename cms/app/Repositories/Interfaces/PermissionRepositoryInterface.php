<?php

namespace App\Repositories\Interfaces;

use App\Models\Permission;

interface PermissionRepositoryInterface {
    public function findAll();
    public function findAllWithPaginate(string $name, string $displayName);
    public function save(array $permissionData);
    public function findById(int $id);
    public function update(array $newPermissionData, Permission $oldPermissionData);
}
