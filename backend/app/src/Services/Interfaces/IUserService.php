<?php 

namespace App\Services\Interfaces;

use App\Models\User;

interface IUserService 
{
    public function getAll(): array;
    public function getById(int $id): User; 
    public function getByEmail(string $email): ?User;
    public function create(User $user): ?User;
    public function delete($id): bool;
    public function update(User $user): ?User;
    // public function authenticate(string $email, string $password): ?User;
    // public function register(User $user): ?User;
}