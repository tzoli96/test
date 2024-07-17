<?php
namespace App\Services;

use App\Http\DTOs\UserDTO;
use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function createUser(UserDTO $userDTO)
    {
        return $this->userRepository->create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => $userDTO->password,
        ]);
    }

    public function updateUser(User $user, UserDTO $userDTO)
    {
        return $this->userRepository->update($user, [
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => $userDTO->password,
        ]);
    }

    public function deleteUser(User $user)
    {
        return $this->userRepository->delete($user);
    }
}
