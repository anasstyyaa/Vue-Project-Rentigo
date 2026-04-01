<?php

namespace App\Framework;

use App\Services\Interfaces\IAuthService;

class Controller
{
    private IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    protected function getAuthenticatedUser()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $this->sendErrorResponse("Unauthorized: No token provided", 401);
            exit; 
        }

        $token = $matches[1];
        $user = $this->authService->getUserFromToken($token);

        if (!$user) {
            $this->sendErrorResponse("Unauthorized: Invalid or expired token", 401);
            exit;
        }

        return $user;
    }

    protected function sendSuccessResponse($data = [], $code = 200)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    protected function sendErrorResponse($message, $code = 500)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode(['error' => $message], JSON_PRETTY_PRINT);
    }

    /**
     * Gets and decodes JSON data from the request body
     * 
     * @return array|null Returns decoded JSON data as array or null if invalid
     */
    protected function getPostData(): ?array
    {
        // checks if it's a standard Form/Multipart submission
        if (!empty($_POST)) {
            return $_POST;
        }

        //for standard API calls
        $input = file_get_contents('php://input');
        if (empty($input)) {
            return [];
        }
        
        return json_decode($input, true) ?? [];
    }
    /**
     * Maps POST data (JSON) to an instance of the specified class
     * 
     * @param string $className The fully qualified class name
     * @return object|null Returns an instance of the class or null if data is invalid
     */
    protected function mapPostDataToClass(string $className): ?object
    {
        $data = $this->getPostData();

        if (empty($data)) {
            return new $className();
        }

        $instance = new $className();
        
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                if ($key === 'profilePicture' && ($value === '[object File]' || empty($value))) {
                    continue; 
                }

                $instance->$key = $value;
            }
        }

        return $instance;
    }
}