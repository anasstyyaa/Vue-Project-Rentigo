<?php 

namespace App\Services; 

use App\Models\User;
use App\Services\Interfaces\IUserservice;
use App\Repositories\Interfaces\IUserRepository;

class UserService implements IUserService
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->getAll();

        // return array_map(function($user) {
        //     unset($user->passwordHash); // avoids passing password to the frontend 
        //     return $user;
        // }, $users);
    }

    public function getByEmail(string $email): ?User
    {
        return $this->repository->getByEmail($email);
    }

    public function getById(int $id): User
    {
        return $this->repository->getById($id);
    }

    public function create(User $user): ?User
    {
        if (empty($user->email) || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("A valid email is required.");
        }

        if (empty($user->firstName) || strlen($user->firstName) < 1) {
            throw new \Exception("First name is too short.");
        }

        if ($this->repository->getByEmail($user->email)) {
            throw new \Exception("Email already exists.");
        }

        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $user->profilePicture = $this->handleFileUpload($_FILES['profilePicture']);
        }

        if (!empty($user->passwordHash)) {
            $user->passwordHash = password_hash($user->passwordHash, PASSWORD_BCRYPT);
        }
        return $this->repository->create($user);
    }

    public function delete($id): bool 
    {
        return $this->repository->delete($id);
    }

    public function update(User $user): ?User
    {
        $existingUser = $this->repository->getById($user->userId);
        if (!$existingUser) {
            throw new \Exception("User not found.");
        }

        $newFileUploaded = false;

        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->handleFileUpload($_FILES['profilePicture']);
            if ($uploadedPath) {
                $user->profilePicture = $uploadedPath;
                $newFileUploaded = true; 
            }
        } 
        
        if (!$newFileUploaded) {
            if ($user->profilePicture === '[object File]' || empty($user->profilePicture)) {
                $user->profilePicture = $existingUser->profilePicture;
            }
        }

        if (empty($user->email)) {
            throw new \Exception("Email cannot be empty.");
        }

        if (!empty($user->passwordHash)) { 
            $user->passwordHash = password_hash($user->passwordHash, PASSWORD_BCRYPT);
        } else {
            $user->passwordHash = $existingUser->passwordHash;
        }

        return $this->repository->update($user);
    }

    private function handleFileUpload(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            error_log("Upload error code: " . $file['error']);
            return null;
        }

        $baseDir = realpath(__DIR__ . '/../../public');
        $uploadDir = $baseDir . '/uploads/users/';

        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'uploads/users/' . $fileName;
        } else {
            error_log("Failed to move file to: " . $targetPath);
        }

        return null;
    }

}