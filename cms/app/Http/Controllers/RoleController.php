<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PermissionRoleRepository;
use App\Models\Role;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    private $roleRepository;
    private $permissionRepository;
    private $permissionRoleRepository;

    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
        PermissionRoleRepository $permissionRoleRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->permissionRoleRepository = $permissionRoleRepository;
    }

    public function index(Request $request) {
        $name = $request->name;
        $displayName = $request->display_name;

        $roles = $this->roleRepository->findAllWithPaginate($name, $displayName);

        return view('role.index', compact('roles'));
    }

    public function create() {
        return view('role.create');
    }

    public function store(RoleRequest $request) {
        $save = $this->roleRepository->save($request->all());

        if ($save) {
            Session::flash("alert-success", "Role sucessfully saved");
        } else {
            Session::flash("alert-danger", "Role unsucessfully saved");
        }

        return redirect()->route('role');
    }

    public function edit(Role $role) {
        return view('role.edit', compact('role'));
    }

    public function update(RoleRequest $request, Role $role) {
        $update = $this->roleRepository->update($request->all(), $role);

        if ($update) {
            Session::flash("alert-success", "Role sucessfully updated");
        } else {
            Session::flash("alert-danger", "Role unsucessfully updated");
        }

        return redirect()->route('role');
    }

    public function accessManagement(Role $role) {
        $permissions = $this->permissionRepository->findAll();
        $permissionRole = $this->permissionRoleRepository->findById($role->id);

        $permissionRoleArr = [];

        foreach ($permissionRole as $item) {
            $permissionRoleArr[] = $item->permission_id;
        }

        return view('role.access-management', compact('role', 'permissions', 'permissionRoleArr'));
    }

    public function accessManagementStore(Request $request) {
        $roleData = $this->permissionRoleRepository->findById($request->role_id);
        $roleId = $request->role_id;

        if (count($roleData) > 0) {
            // update data
            $role = $this->roleRepository->findById($roleId);

            // delete data permission per role
            foreach ($roleData as $key => $value) {
                $role->detachPermission($value->permission_id);
            }

            // insert data permission per role
            foreach ($request->checkbox_permission as $key => $value) {
                $role->attachPermission($value);
            }

            Session::flash('alert-success', 'Access management successfully updated.');
        } else {
            // insert data
            $role = $this->roleRepository->findById($roleId);

            foreach ($request->checkbox_permission as $key => $value) {
                $role->attachPermission($value);
            }

            Session::flash('alert-success', 'Access management successfully added.');
        }

        return redirect()->route('role');
    }
}
