<?php

namespace App\Models;

class UserDTO
{
    public int $userId;
    public string $username;
    public string $firstName;
    public string $email;
    public int $roleId;

    public function __construct(User $user)
    {
        $this->userId = $user->userId;
        $this->username = $user->Username ?? $user->username ?? '';
        $this->firstName = $user->FirstName ?? $user->firstName ?? '';
        $this->email = $user->email;
        $this->roleId = $user->roleId;

    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'email' => $this->email,
            'roleId' => $this->roleId
        ];
    }
}