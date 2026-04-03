<?php 

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Framework\Repository;
use PDO;

class UserRepository extends Repository implements IUserRepository 
{
    public function getAll(): array
    {
        $sql = "SELECT 
                    UserId AS userId, 
                    RoleId AS roleId, 
                    Username AS username,
                    FirstName AS firstName, 
                    LastName AS lastName, 
                    Email AS email, 
                    ProfilePicture AS profilePicture,
                    PhoneNumber AS phoneNumber, 
                    PasswordHash AS passwordHash, 
                    CreatedAt AS createdAt, 
                    IsActive AS isActive 
                FROM Users
                WHERE IsActive = 1";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $stmt->fetchAll();
    }

    public function getByEmail(string $email): ?User
    {
        $sql = "SELECT 
                    UserId AS userId, 
                    RoleId AS roleId, 
                    Username AS username,
                    FirstName AS firstName, 
                    LastName AS lastName, 
                    Email AS email, 
                    ProfilePicture AS profilePicture,
                    PhoneNumber AS phoneNumber, 
                    PasswordHash AS passwordHash, 
                    CreatedAt AS createdAt, 
                    IsActive AS isActive 
                FROM Users 
                WHERE Email = :email AND IsActive = 1 LIMIT 1";

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
                    ProfilePicture AS profilePicture, 
                    PhoneNumber AS phoneNumber, 
                    PasswordHash AS passwordHash, 
                    CreatedAt AS createdAt, 
                    IsActive AS isActive 
                FROM Users
                WHERE UserId = :id AND isActive = 1";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([':id' => $id]);

        $stmt->setFetchMode(\PDO::FETCH_CLASS, \App\Models\User::class);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function create(User $user): ?User
    {
        $sql = "INSERT INTO Users (RoleId, Username, FirstName, LastName, Email, ProfilePicture, PhoneNumber, PasswordHash, IsActive) 
                VALUES (:roleId, :username, :firstName, :lastName, :email, :profilePicture, :phoneNumber, :passwordHash, :isActive)";

        $stmt = $this->getConnection()->prepare($sql);
        $result = $stmt->execute([
            ':roleId' => $user->roleId,
            ':username' => $user->username,
            ':firstName' => $user->firstName,
            ':lastName' => $user->lastName,
            ':email' => $user->email,
            ':profilePicture' => $user->profilePicture,
            ':phoneNumber' => $user->phoneNumber,
            ':passwordHash' => $user->passwordHash,
            ':isActive' => ($user->isActive === 'true' || $user->isActive === true || $user->isActive === 1) ? 1 : 0,
        ]);

        if ($result) {
            $user->userId = (int)$this->getConnection()->lastInsertId();
            unset($user->passwordHash); // never returning the password to the frontend 
            return $user;
        }

        return null;
    }

    public function delete($id): bool 
    {
        $sql = "UPDATE Users SET IsActive = 0 WHERE UserId = :id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function update(User $user): ?User
    {
        $sql = "UPDATE Users SET 
                    RoleId = :roleId, 
                    Username = :username, 
                    FirstName = :firstName, 
                    LastName = :lastName, 
                    Email = :email, 
                    ProfilePicture = :profilePicture,
                    PhoneNumber = :phoneNumber, 
                    PasswordHash = :passwordHash, 
                    IsActive = :isActive
                WHERE UserId = :userId";

        $stmt = $this->getConnection()->prepare($sql);
        $result = $stmt->execute([
            ':roleId' => $user->roleId,
            ':username' => $user->username,
            ':firstName' => $user->firstName,
            ':lastName' => $user->lastName,
            ':email' => $user->email,
            ':profilePicture' => $user->profilePicture,
            ':phoneNumber' => $user->phoneNumber,
            ':passwordHash' => $user->passwordHash,
            ':isActive' => ($user->isActive === 'true' || $user->isActive === true || $user->isActive === 1) ? 1 : 0,
            ':userId' => $user->userId
        ]);

        if ($result) {
            unset($user->passwordHash); // never returning the password to the frontend 
            return $user;
        }

        return null;
    }
}
