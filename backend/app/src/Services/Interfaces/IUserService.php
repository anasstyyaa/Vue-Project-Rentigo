<?php 

namespace App\Services\Interfaces;

use App\Models\User;

interface IUserService 
{
    public function getByEmail(string $email): ?User;
    public function create(User $user): ?User;
    public function authenticate(string $email, string $password): ?User;
     public function register(User $user): ?User;
}