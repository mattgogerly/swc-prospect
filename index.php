<?php

require __DIR__ . '/vendor/autoload.php';

use FastRoute\Dispatcher;
use DI\Container;

const HANDLER_DELIMITER = '@';
const STATIC_ROOT = './swcprospect/view/static'; 

$container = new Container();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/', 'swcprospect\controller\HomeController@home');

    $r->get('/type/planet', 'swcprospect\controller\EntityTypeController@planetTypes');
    $r->get('/type/deposit', 'swcprospect\controller\EntityTypeController@depositTypes');

    $r->get('/planets/view', 'swcprospect\controller\PlanetController@planetsListView');
    $r->get('/planet/{id:\d+}/view', 'swcprospect\controller\PlanetController@planetView');
    $r->get('/planet/{id:\d+}', 'swcprospect\controller\PlanetController@planet');
    $r->post('/planets', 'swcprospect\controller\PlanetController@save');
    $r->delete('/planet/{id:\d+}', 'swcprospect\controller\PlanetController@delete');

    $r->get('/deposit/{id:\d+}/view', 'swcprospect\controller\DepositController@depositView');
    $r->delete('/deposit/{id:\d+}', 'swcprospect\controller\DepositController@delete');
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $dispatcher->dispatch($method, $uri);
list($state, $handler, $vars) = $routeInfo;

switch ($state) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        return;
    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        return;
    case Dispatcher::FOUND:
        list($class, $method) = explode(HANDLER_DELIMITER, $handler, 2);

        $controller = $container->get($class);
        $controller->{$method}(...array_values($vars));
        return;
    default:
        echo "Error routing request";
        return;
}

?>