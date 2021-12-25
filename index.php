<?php

require __DIR__ . '/vendor/autoload.php';

use FastRoute\Dispatcher;
use DI\Container;

const HANDLER_DELIMITER = '@';
const STATIC_ROOT = './swcprospect/view/static'; 

$container = new Container();

function errorHandler(int $errno, string $errstr): bool {
    if (str_contains($errstr, '400')) {
        $errorCode = 400;
    } else if (str_contains($errstr, '404')) {
        $errorCode = 404;
    } else {
        $errorCode = 500;
    }

    header('X-Error-Message: ' .  $errstr, true, $errorCode);
    die($errstr);
}
set_error_handler("errorHandler");

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', 'swcprospect\controller\HomeController@home');

    $r->get('/type/planet', 'swcprospect\controller\EntityTypeController@planetTypes');
    $r->get('/type/deposit', 'swcprospect\controller\EntityTypeController@depositTypes');

    $r->get('/planets/view', 'swcprospect\controller\PlanetController@planetsListView');
    $r->post('/planets', 'swcprospect\controller\PlanetController@save');

    $r->get('/planet/{id:\d+}', 'swcprospect\controller\PlanetController@planet');
    $r->get('/planet/{id:\d+}/view', 'swcprospect\controller\PlanetController@planetView');
    $r->delete('/planet/{id:\d+}', 'swcprospect\controller\PlanetController@delete');

    $r->post('/deposits', 'swcprospect\controller\DepositController@save');
    $r->get('/deposit/{planet:\d+}/{x:\d+}/{y:\d+}', 'swcprospect\controller\DepositController@deposit');
    $r->get('/deposit/{planet:\d+}/{x:\d+}/{y:\d+}/view', 'swcprospect\controller\DepositController@depositView');
    $r->delete('/deposit/{planet:\d+}/{x:\d+}/{y:\d+}', 'swcprospect\controller\DepositController@delete');
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $dispatcher->dispatch($method, $uri);
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        return;
    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        return;
    case Dispatcher::FOUND:
        list(, $handler, $vars) = $routeInfo;

        // override POST body if POST
        $vars = $_SERVER['REQUEST_METHOD'] == 'POST' ? json_decode(file_get_contents('php://input'), true) : $vars;

        list($class, $method) = explode(HANDLER_DELIMITER, $handler, 2);

        $controller = $container->get($class);
        $controller->{$method}(...array_values($vars));
        return;
    default:
        trigger_error('Error routing request');
}

?>