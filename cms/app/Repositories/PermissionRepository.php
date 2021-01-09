<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface {

    public function findAll() {
        return Permission::orderBy('id', 'desc')->get();
    }

    public function findAllWithPaginate(string $name = null, string $displayName = null) {
        return Permission::when($name, function($q) use ($name) {
            return $q->where('name', 'like', "%{$name}%");
        })
        ->when($displayName, function($q) use ($displayName) {
            return $q->where('display_name', 'like', "%{$displayName}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
    }

    public function save(array $permissionData) {
        $permission = new Permission($permissionData);

        return $permission->save();
    }

    public function findById(int $id) {
        return Permission::findOrFail($id);
    }

    public function update(array $newPermissionData, Permission $oldPermissionData) {
        return $oldPermissionData->update($newPermissionData);
    }
}
