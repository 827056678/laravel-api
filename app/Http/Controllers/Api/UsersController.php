<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('refresh.token', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $users = User::paginate();
        return $this->success($users);
    }

    public function show(User $user)
    {
        return $this->success(compact('user'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return $this->success($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->all());

        return $this->success($user);
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();

        return $this->success($user);
    }
}
