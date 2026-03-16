<?php 

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function getAll(): array;
    public function getByEmail(string $email): ?User;
    public function getById(int $id): User;
    public function create(User $user): ?User;
    public function delete($id): bool; 
    public function update(User $user): ?User;
}