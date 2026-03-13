<?php 

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Framework\Repository;
use PDO;

class UserRepository extends Repository implements IUserRepository 
{
    public function getByEmail(string $email): ?User
    {
        $sql = "SELECT 
                    UserId AS userId, 
                    RoleId AS roleId, 
                    Username AS username,
                    FirstName AS firstName, 
                    LastName AS lastName, 
                    Email AS email, 
                    PhoneNumber AS phoneNumber, 
                    PasswordHash AS passwordHash, 
                    CreatedAt AS createdAt, 
                    IsActive AS isActive 
                FROM Users 
                WHERE Email = :email LIMIT 1";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([':email' => $email]);
        
        $user = $stmt->fetchObject(User::class);
        return $user ?: null;
    }

    public function getById(int $id): User
    {
        $sql = "SELECT 
                    UserId AS userId, 
                    RoleId AS roleId, 
                    Username AS username,
                    FirstName AS firstName, 
                    LastName AS lastName, 
                    Email AS email, 
                    PhoneNumber AS phoneNumber, 
                    PasswordHash AS passwordHash, 
                    CreatedAt AS createdAt, 
                    IsActive AS isActive 
                FROM Users
                WHERE UserId = :id AND IsDeleted = 0";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([':id' => $id]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, \App\Models\User::class);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create(User $user): ?User
    {
        $sql = "INSERT INTO Users (RoleId, Username, FirstName, LastName, Email, PhoneNumber, PasswordHash, IsActive) 
                VALUES (:roleId, :username, :firstName, :lastName, :email, :phoneNumber, :passwordHash, :isActive)";

        $stmt = $this->getConnection()->prepare($sql);
        $result = $stmt->execute([
            ':roleId' => $user->roleId,
            ':username' => $user->username,
            ':firstName' => $user->firstName,
            ':lastName' => $user->lastName,
            ':email' => $user->email,
            ':phoneNumber' => $user->phoneNumber,
            ':passwordHash' => $user->passwordHash,
            ':isActive' => (int)$user->isActive
        ]);

        if ($result) {
            $user->userId = (int)$this->getConnection()->lastInsertId();
            unset($user->passwordHash); // never returning the password to the frontend 
            return $user;
        }

        return null;
    }
}
