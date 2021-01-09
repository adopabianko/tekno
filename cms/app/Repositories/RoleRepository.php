<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleRepository implements RoleRepositoryInterface {

    public function findAll() {
        return Role::orderBy('id', 'desc')->get();
    }

    public function findAllWithPaginate(string $name = null, string $displayName = null) {
        return Role::when($name, function($q) use ($name) {
            return $q->where('name', 'like', "%{$name}%");
        })
        ->when($displayName, function($q) use ($displayName) {
            return $q->where('display_name', 'like', "%{$displayName}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
    }

    public function save(array $roleData) {
        $role = new Role($roleData);

        return $role->save();
    }

    public function findById(int $id) {
        return Role::findOrFail($id);
    }

    public function update(array $newRoleData, Role $oldRoleData) {
        return $oldRoleData->update($newRoleData);
    }
}
