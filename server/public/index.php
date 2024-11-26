<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Infraestructure/Persistence/doctrine.php';

use App\Presentation\GraphQL;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$entityManager = require __DIR__ . '/../src/Infraestructure/Persistence/doctrine.php';

$graphql = new GraphQL($entityManager);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) use ($graphql) {
    $r->post('/graphql', [$graphql, 'handle']);
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

try {
    $routeInfo = $dispatcher->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI']
    );

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed', 'allowed_methods' => $allowedMethods]);
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];
            echo $handler($vars);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
}
