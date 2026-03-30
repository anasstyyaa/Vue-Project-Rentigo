<?php 

namespace App\Controllers;

use App\Models\User;
use App\Models\UserDTO;
use App\Services\Interfaces\IUserService;
use App\Services\Interfaces\IAuthService;
use App\Framework\Controller;

class UserController extends Controller
{
    private IUserService $userService;
    private IAuthService $authService;

    public function __construct(IUserService $userService, IAuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    public function index(){
        try {
            $users = $this->userService->getAll(); 
            header ('Content-Type: application/json');
            echo json_encode($users);

        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred while fetching users', 500);
        }
    }

    public function delete($id){
        try {
            $success = $this->userService->delete($id);
            if ($success) {
            return $this->sendSuccessResponse(['message' => 'Deleted successfully']);
            }
            return $this->sendErrorResponse('User not found', 404);
            header('Content-Type: application/json'); 
            return json_encode(['success' => $success]);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function update($id){
        try {
            
            $user = $this->mapPostDataToClass(User::class);
            $user->userId = $id; 
            $updatedUser = $this->userService->update($user);

            if ($updatedUser) {
                return $this->sendSuccessResponse($updatedUser);
            } else {
                return $this->sendErrorResponse('User not found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function create(){
        try {
            $user = $this->mapPostDataToClass(User::class);
            $created = $this->userService->create($user);
            return $this->sendSuccessResponse($created, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }


    public function login()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            if (empty($email) || empty($password)) {
                return $this->sendErrorResponse('Email and password are required', 400);
            }

            $user = $this->authService->authenticate($email, $password);

            if (!$user) {
                return ($this->sendErrorResponse('Invalid email or password', 401));
            }

            $userDTO = new UserDTO($user);
            $token = $this->authService->generateToken($user);

            return $this->sendSuccessResponse([
                'user' => $userDTO,
                'token' => $token, 
            ]);

        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred during login', 500);
        }
    }

    public function register()
    {
        try {
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

            $user->roleId = 1; // Default to regular user role

            $createdUser = $this->authService->register($user);

            if ($createdUser) {
                return $this->sendSuccessResponse($createdUser, 201);
            }

            return $this->sendErrorResponse('Registration failed', 409);

        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                return $this->sendErrorResponse('This email is already registered.', 409);
            }

            return $this->sendErrorResponse('Database error: ' . $e->getMessage(), 500);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Server error: ' . $e->getMessage(), 500);
        }
    }

    public function currentUser()
    {
        try {
            if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
                return $this->sendErrorResponse('Authorization header is required', 401);
            }

            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            $headerParts = explode(' ', $authHeader);
            if (count($headerParts) !== 2 || strtolower($headerParts[0]) !== 'bearer') {
                return $this->sendErrorResponse('Invalid authorization header format', 401);
            }
            $token = $headerParts[1];

            $user = $this->authService->getUserFromToken($token);

            if (!$user) {
                return $this->sendErrorResponse('Invalid or expired token', 401);
            }

            // Return user DTO
            $userDTO = new UserDTO($user);
            return $this->sendSuccessResponse($userDTO);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function getProfile() {
        try {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                return $this->sendErrorResponse("No token provided", 401);
            }

            $token = $matches[1];
            $user = $this->authService->getUserFromToken($token);

            if (!$user) {
                return $this->sendErrorResponse("Invalid or expired token", 401);
            }

            $userDTO = new UserDTO($user);
            return $this->sendSuccessResponse($userDTO->toArray());
            
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }


}