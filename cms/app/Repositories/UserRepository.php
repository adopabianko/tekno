<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface {

    public function findAll() {
        return User::with('role_user.role')
        ->where('active', 1)
        ->orderBy('id', 'desc')->get();
    }

    public function findAllWithPaginate(string $role = null, string $name = null, string $email = null) {
        return User::with('role_user.role')
        ->when($role && $role !== 'all', function($q) use ($role) {
            $q->whereHas('role_user.role', function($q) use ($role) {
                return $q->where('name', $role);
            });
        })
        ->when($name, function($q) use ($name){
            return $q->where('name', 'like', "%{$name}%");
        })
        ->when($email, function($q) use ($email){
            return $q->where('email', 'like', "%{$email}%");
        })
        ->where('active', 1)
        ->orderBy('id', 'desc')->paginate(10);
    }

    public function save(array $userData) {
        DB::beginTransaction();

        try {
            $roleId = $userData['role_id'];

            unset($userData['role_id']);

            $user = new User($userData);
            $user->password = Hash::make($userData['password']);

            $user->save();
            $user->attachRole($roleId);

            DB::commit();

            return true;
        } catch(\Exception $e) {
            DB::rollback();

            return false;
        }

    }

    public function findRoleUser(int $userId) {
        return RoleUser::where('user_id', $userId)->first();
    }

    public function update(array $newUserData, User $oldUserData) {
        DB::beginTransaction();

        try {
            $password = $newUserData['password'];

            if (!empty($password)) {
                $password = Hash::make($password);

                $newUserData['password'] = $password;
            } else {
                unset($newUserData['password']);
            }

            $roleId = $newUserData['role_id'];

            unset($newUserData['role_id']);

            $oldUserData->update($newUserData);

            $oldUserData->syncRoles([$roleId]);

            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    public function destroy(int $id) {
        return User::where('id', $id)->update(['active' => 0]);
    }

    public function profileUpdate(array $newUserData, User $oldUserData) {
        $newUserData['password'] = Hash::make($newUserData['password']);

        return $oldUserData->update($newUserData);
    }
}
