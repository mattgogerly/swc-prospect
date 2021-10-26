<?php

require __DIR__ . '/vendor/autoload.php';

use DI\Container;
use Pux\Executor;
use Pux\Mux;

$container = new Container();

$planetController = $container->get('swcprospect\controller\PlanetController');

$mux = new Mux;
$mux->any('/index.php', $planetController->planets());

$route = $mux->dispatch($_SERVER['REQUEST_URI']);

echo Executor::execute($route);

?>