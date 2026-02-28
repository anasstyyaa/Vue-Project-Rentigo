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

    public function getByEmail(string $email): ?User
    {
        return $this->repository->getByEmail($email);
    }

    public function create(User $user): ?User
    {
        return $this->repository->create($user);
    }

    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->repository->getByEmail($email);

        if ($user && password_verify($password, $user->passwordHash)) {
            unset($user->passwordHash);
            return $user;
        }

        return null;
    }

    public function register(User $user): ?User
    {
        $user->passwordHash = password_hash($user->passwordHash, PASSWORD_BCRYPT);

        return $this->repository->create($user);
    }
}