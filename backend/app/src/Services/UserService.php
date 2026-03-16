<?php 

namespace App\Services; 

use App\Models\User;
use App\Services\Interfaces\IUserservice;
use App\Repositories\Interfaces\IUserRepository;

class UserService implements IUserService
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->getAll();

        return array_map(function($user) {
            unset($user->passwordHash); // avoids passing password to the frontend 
            return $user;
        }, $users);
    }

    public function getByEmail(string $email): ?User
    {
        return $this->repository->getByEmail($email);
    }

    public function create(User $user): ?User
    {
        if (empty($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("A valid email is required.");
        }

        if (empty($user->firstName) || strlen($user->firstName) < 1) {
            throw new \Exception("First name is too short.");
        }

        if ($this->repository->getByEmail($user->email)) {
            throw new \Exception("Email already exists.");
        }

        if (!empty($user->passwordHash)) {
            $user->passwordHash = password_hash($user->passwordHash, PASSWORD_BCRYPT);
        }
        return $this->repository->create($user);
    }

    public function delete($id): bool 
    {
        return $this->repository->delete($id);
    }

    public function update(User $user): ?User
    {
        $existingUser = $this->repository->getById($user->userId);
        if (!$existingUser) {
            throw new \Exception("User not found.");
        }

        if (empty($user->email)) {
            throw new \Exception("Email cannot be empty.");
        }

        if (!empty($user->passwordHash)) { 
        $user->passwordHash = password_hash($user->passwordHash, PASSWORD_BCRYPT);
        } else {
            $user->passwordHash = $existingUser->passwordHash;
        }
        return $this->repository->update($user);
    }

    // public function authenticate(string $email, string $password): ?User
    // {
    //     $user = $this->repository->getByEmail($email);

    //     if ($user && password_verify($password, $user->passwordHash)) {
    //         unset($user->passwordHash);
    //         return $user;
    //     }

    //     return null;
    // }

    // public function register(User $user): ?User
    // {
    //     $user->passwordHash = password_hash($user->passwordHash, PASSWORD_BCRYPT);

    //     return $this->repository->create($user);
    // }
}