<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{
    private $permissionRepository;

    public function __construct(
        PermissionRepository $permissionRepository
    ) {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request) {
        $name = $request->name;
        $displayName = $request->display_name;

        $permissions = $this->permissionRepository->findAllWithPaginate($name, $displayName);

        return view('permission.index', compact('permissions'));
    }

    public function create() {
        return view('permission.create');
    }

    public function store(PermissionRequest $request) {
        $save = $this->permissionRepository->save($request->all());

        if ($save) {
            Session::flash("alert-success", "Permission sucessfully saved");
        } else {
            Session::flash("alert-danger", "Permission unsucessfully saved");
        }

        return redirect()->route('permission');
    }

    public function edit(Permission $permission) {
        return view('permission.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission) {
        $update = $this->permissionRepository->update($request->all(), $permission);

        if ($update) {
            Session::flash("alert-success", "Permission sucessfully updated");
        } else {
            Session::flash("alert-danger", "Permission unsucessfully updated");
        }

        return redirect()->route('permission');
    }
}
