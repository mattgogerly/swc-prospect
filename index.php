<?php

require __DIR__ . '/vendor/autoload.php';

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use DI\Container;

/**
 **** ERROR HANDLING ****
 */
error_reporting(0);

// handler for exceptions thrown by trigger_exception
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

// handler for fatal errors
function fatalErrorHandler(): void {
    $error = error_get_last();
    if ($error) {
        error_log($error['message']);
        errorHandler(0, '500: Fatal error');
    }
}
register_shutdown_function("fatalErrorHandler");


/**
 **** ROUTING ****
 */
const HANDLER_DELIMITER = '@';
const STATIC_ROOT = './swcprospect/view/static'; 

$container = new Container();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', 'swcprospect\controller\HomeController@home');

    $r->addGroup('/type', function (RouteCollector $r) {
        $r->get('/planet', 'swcprospect\controller\EntityTypeController@planetTypes');
        $r->get('/deposit', 'swcprospect\controller\EntityTypeController@depositTypes');
    });

    $r->addGroup('/planets', function (RouteCollector $r) {
        $r->get('', 'swcprospect\controller\PlanetController@planetListView');
        $r->post('', 'swcprospect\controller\PlanetController@save');
    });

    $r->addGroup('/planet/{planetId:\d+}', function (RouteCollector $r) {
        $r->get('', 'swcprospect\controller\PlanetController@planet');
        $r->get('/json', 'swcprospect\controller\PlanetController@planetJson');
        $r->delete('', 'swcprospect\controller\PlanetController@delete');

        $r->addGroup('/deposits', function (RouteCollector $r) {   
            $r->get('', 'swcprospect\controller\DepositController@depositListView');
            $r->post('', 'swcprospect\controller\DepositController@save');
        });

        $r->addGroup('/deposit', function (RouteCollector $r) {   
            $r->get('/x/{x:\d+}/y/{y:\d+}/json', 'swcprospect\controller\DepositController@depositJson');
            $r->get('/x/{x:\d+}/y/{y:\d+}', 'swcprospect\controller\DepositController@deposit');
            $r->delete('/x/{x:\d+}/y/{y:\d+}', 'swcprospect\controller\DepositController@delete');
        });
    });
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
        echo $controller->{$method}(...$vars);
        return;
    default:
        trigger_error('Error routing request');
}

?>