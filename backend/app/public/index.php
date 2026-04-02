<?php

/**
 * This is the central route handler of the application.
 * It uses FastRoute to map URLs to controller methods.
 * 
 * See the documentation for FastRoute for more information: https://github.com/nikic/FastRoute
 */

// CORS headers for localhost requests
// $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
// if (preg_match('/^https?:\/\/(localhost|127\.0\.0\.1|::1)(:\d+)?$/', $origin)) {
//     header('Access-Control-Allow-Origin: ' . $origin);
//     // Specifies which HTTP methods are allowed when accessing the resource from the origin
//     header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//     // Specifies which HTTP headers can be used when making the actual request
//     header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-HTTP-Method-Override, Accept, Origin');
//     // Allows cookies and authentication credentials to be sent with cross-origin requests
//     header('Access-Control-Allow-Credentials: true');
//     // Specifies how long (in seconds) the browser can cache the preflight response (24 hours)
//     header('Access-Control-Max-Age: 86400');
// }

// // Handle preflight OPTIONS requests
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit;
// }

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * Define the routes for the application.
 */
$dispatcher = simpleDispatcher(function (RouteCollector $r) {

    // cars 
    $r->addRoute('GET', '/api/cars', ['App\Controllers\CarController', 'getAll']);
    $r->addRoute('POST', '/api/cars', ['App\Controllers\CarController', 'create']);
    $r->addRoute(['PUT', 'POST'], '/api/cars/{id:\d+}', ['App\Controllers\CarController', 'update']);
    $r->addRoute('GET', '/api/cars/{id:\d+}', ['App\Controllers\CarController', 'get']);
    $r->addRoute('DELETE', '/api/cars/{id:\d+}', ['App\Controllers\CarController', 'delete']);
    $r->addRoute('POST', '/api/cars/delete-image', ['App\Controllers\CarController', 'deleteImage']);
    $r->addRoute('POST', '/api/cars/set-main-image', ['App\Controllers\CarController', 'setMain']);

    // users
    $r->addRoute('POST', '/api/login', ['App\Controllers\UserController', 'login']);
    $r->addRoute('POST', '/api/register', ['App\Controllers\UserController', 'register']);
    $r->addRoute('GET', '/api/profile', ['App\Controllers\UserController', 'getProfile']);

    // rentals 
    $r->addRoute('GET', '/api/my-bookings', ['App\Controllers\RentalController', 'getMyBookings']);
    $r->addRoute('POST', '/api/bookings', ['App\Controllers\RentalController', 'store']);
    $r->addRoute('POST', '/api/bookings/{id:\d+}/cancel', ['App\Controllers\RentalController', 'cancel']);

    // reviews
    $r->addRoute('POST', '/api/reviews', ['App\Controllers\ReviewController', 'handlePost']);

 
    // admin 
    $r->addRoute('GET', '/api/users', ['App\Controllers\UserController', 'index']); 
    $r->addRoute('DELETE', '/api/users/{id:\d+}', ['App\Controllers\UserController', 'delete']);
    $r->addRoute('POST', '/api/users', ['App\Controllers\UserController', 'create']);
    $r->addRoute(['PUT', 'POST'], '/api/users/{id:\d+}', ['App\Controllers\UserController', 'update']);
    $r->addRoute('GET', '/api/admin/bookings', ['App\Controllers\RentalController', 'getDashboardBookings']);
    
});


/**
 * Get the request method and URI from the server variables and invoke the dispatcher.
 */
$httpMethod = $_SERVER['REQUEST_METHOD'];

$methodOverride = $_POST['_method'] ?? $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] ?? null;

if ($httpMethod === 'POST' && $methodOverride) {
    $methodOverride = strtoupper($methodOverride);
    if (in_array($methodOverride, ['PUT', 'DELETE'])) {
        $httpMethod = $methodOverride;
    }
}

$uri = strtok($_SERVER['REQUEST_URI'], '?');
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

/**
 * Switch on the dispatcher result and call the appropriate controller method if found.
 */
switch ($routeInfo[0]) {
    // Handle not found routes
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Not Found';
        break;
    // Handle routes that were invoked with the wrong HTTP method
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo 'Method Not Allowed';
        break;
    // Handle found routes
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1]; 
        $vars = $routeInfo[2];    
        $class = $handler[0];
        $method = $handler[1];

        if ($class === 'App\Controllers\CarController') {

            $repository = new \App\Repositories\CarRepository();
            $service = new \App\Services\CarService($repository);
            $controller = new $class($service);

        } elseif ($class === 'App\Controllers\UserController') {

            $repository = new \App\Repositories\UserRepository();
            $service = new \App\Services\UserService($repository);
            $authService = new \App\Services\AuthService();
            $controller = new $class($service, $authService);

        } elseif ($class === 'App\Controllers\RentalController') {
            $repository = new \App\Repositories\RentalRepository();
            $carRepository = new \App\Repositories\CarRepository();
            $service = new \App\Services\RentalService($repository, $carRepository);
            $authService = new \App\Services\AuthService();
            $controller = new $class($service, $authService);
        
        } elseif ($class === 'App\Controllers\ReviewController') {
            $repository = new \App\Repositories\ReviewRepository();
            $service = new \App\Services\ReviewService($repository);
            $authService = new \App\Services\AuthService();
            $controller = new $class($service, $authService);
        
        } else {
            $controller = new $class();
        }
        
        call_user_func_array([$controller, $method], array_values($vars));
        break;
}