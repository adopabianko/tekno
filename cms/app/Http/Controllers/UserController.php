<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\ProfileRequest;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Models\User;
use App\Jobs\SendUserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request) {
        $role = $request->role;
        $name = $request->name;
        $email = $request->email;

        $users = $this->userRepository->findAllWithPaginate($role, $name, $email);
        $roles = $this->roleRepository->findAll();

        return view('user.index', compact('users', 'roles'));
    }

    public function create() {
        $roles = $this->roleRepository->findAll();

        return view('user.create', compact('roles'));
    }

    public function store(UserRequest $request) {
        try {
            $reqAll = $request->all();

            // send to email user
            SendUserAccount::dispatch($reqAll);

            $this->userRepository->save($reqAll);

            Session::flash("alert-success", "User successfully saved");
        } catch(Exception $e) {
            Session::flash("alert-danger", "User unsuccessfully saved");
        }

        return redirect()->route('user');
    }

    public function edit(User $user) {
        $roles = $this->roleRepository->findAll();
        $roleUser = $this->userRepository->findRoleUser($user->id);

        return view('user.edit', compact('roles', 'roleUser', 'user'));
    }

    public function update(UserRequest $request, User $user) {
        try {
            // send to email user
            SendUserAccount::dispatch($request->all());

            $this->userRepository->update($request->all(), $user);

            Session::flash("alert-success", "User successfully updated");
        } catch(Exception $e) {
            Session::flash("alert-danger", "User unsuccessfully updated");
        }

        return redirect()->route('user');
    }

    public function destroy(User $user) {
        $destroy = $this->userRepository->destroy($user->id);

        if (!$destroy) {
            return response()->json([
                'status' => 'error',
                'message' => 'User unsuccessfully destroyed',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully destroyed',
        ]);
    }

    public function profile() {
        $userId = Auth::user()->id;

        $user = User::where('id', $userId)->first();

        return view('user.profile', compact('user'));
    }

    public function profileUpdate(ProfileRequest $request, User $user) {
        $update = $this->userRepository->profileUpdate($request->all(), $user);

        if ($update) {
            Session::flash("alert-success", "Profile successfully updated");
        } else {
            Session::flash("alert-danger", "Profile unsuccessfully updated");
        }

        return redirect()->route('user.profile');
    }
}
