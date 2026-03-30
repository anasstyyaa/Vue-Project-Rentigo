<?php

namespace App\Models;

class UserDTO
{
    public int $userId;
    public string $username;
    public string $firstName;
    public string $lastName; 
    public string $email;
    public string $phoneNumber;
    public ?string $profilePicture; 
    public string $createdAt; 
    public int $roleId;

    public function __construct(User $user)
    {
        $this->userId = $user->userId;
        // Check your User model/DB column names. If DB is 'username', use $user->username
        $this->username = $user->username ?? $user->Username ?? 'N/A';
        $this->firstName = $user->firstName ?? $user->FirstName ?? '';
        $this->lastName = $user->lastName ?? $user->LastName ?? '';
        $this->email = $user->email;
        $this->profilePicture = $user->profilePicture ?? null;
        $this->createdAt = $user->CreatedAt ?? date('Y-m-d');
        $this->roleId = $user->roleId;
        $this->phoneNumber = $user->phoneNumber ?? $user->phone ?? 'Not provided';
    }

    public function toArray(): array
    {
        return get_object_vars($this); // a shortcut to return all public properties
    }
}