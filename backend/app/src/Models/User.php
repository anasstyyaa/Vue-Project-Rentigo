<?php 

namespace App\Models;

class User
{
    public int $userId = 0;
    public int $roleId = 0;
    public string $firstName = "";
    public string $lastName = "";
    public string $email = "";
    public string $phoneNumber = "";
    public string $passwordHash = ""; 
    public string $createdAt = "";
    public bool $isActive = true;
}