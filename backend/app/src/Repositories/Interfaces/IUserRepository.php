<?php 

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function getByEmail(string $email): ?User;
    public function create(User $user): ?User;
}