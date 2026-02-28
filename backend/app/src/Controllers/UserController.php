<?php 

namespace App\Controllers;

use App\Models\User;
use App\Services\Interfaces\IUserService;
use App\Framework\Controller;

class UserController extends Controller
{
    private IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            return $this->sendErrorResponse('Email and password are required', 400);
        }

        $user = $this->userService->authenticate($email, $password);

        if ($user) {
            return $this->sendSuccessResponse([
                'message' => 'Login successful',
                'user' => $user
            ]);
        }

        return $this->sendErrorResponse('Invalid credentials', 401);
    }

    public function register()
    {
        $user = $this->mapPostDataToClass(User::class);

        if (empty($user->email) || empty($user->passwordHash)) {
            return $this->sendErrorResponse('Email and password are required', 400);
        }

        if (empty($user->phoneNumber)) {
            return $this->sendErrorResponse('Phone number is required', 400);
        }

        if (empty($user->firstName) || empty($user->lastName)) {
            return $this->sendErrorResponse('First name and last name are required', 400);
        }

        $createdUser = $this->userService->register($user);

        if ($createdUser) {
            return $this->sendSuccessResponse($createdUser, 201);
        }

        return $this->sendErrorResponse('Registration failed', 409);
    }

}