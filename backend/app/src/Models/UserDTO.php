<?php

namespace App\Models;

class UserDTO
{
    public int $id;
    public string $username;
    public string $firstName;
    public string $email;
    public int $roleId;

    public function __construct(User $user)
    {
        $this->id = $user->userId;
        $this->username = $user->Username ?? $user->username ?? '';
        $this->firstName = $user->FirstName ?? $user->firstName ?? '';
        $this->email = $user->email;
        $this->roleId = $user->roleId;

    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstName' => $this->firstName,
            'email' => $this->email,
            'roleId' => $this->roleId
        ];
    }
}