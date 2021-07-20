<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('refresh.token', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, User $user)
    {
        $users = $user->query()->filter($request->all())->simplePaginate(5);
        return UserResource::collection($users);
    }

    public function show(Request $request, User $user)
    {
        $authUser = $request->user;
        $user = new UserResource($user);
        return $this->success(compact('user', 'authUser'));
    }

    public function store(UserRequest $request)
    {
        $user = User::query()->create($request->all());
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
