<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/error.php';

use DI\Container;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

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

        // override POST body with JSON content since that's what we're sending from the frontend
        $vars = $_SERVER['REQUEST_METHOD'] == 'POST' ? json_decode(file_get_contents('php://input'), true) : $vars;

        list($class, $method) = explode(HANDLER_DELIMITER, $handler, 2);

        $controller = $container->get($class);

        try {
            echo $controller->{$method}(...$vars);
        } catch (TypeError $e) {
            trigger_error('400: Invalid type for argument');
        }

        return;
    default:
        trigger_error('Error routing request');
}
?>