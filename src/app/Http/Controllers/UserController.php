<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Http\DTOs\UserDTO;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $userDTO = new UserDTO(
            $request->input('name'),
            $request->input('email'),
            bcrypt($request->input('password'))
        );

        $user = $this->userService->createUser($userDTO);
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->getUserById($id);

        $userDTO = new UserDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('password') ? bcrypt($request->input('password')) : $user->password
        );

        $user = $this->userService->updateUser($user, $userDTO);
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = $this->userService->getUserById($id);
        $this->userService->deleteUser($user);

        return response()->json(null, 204);
    }
}
