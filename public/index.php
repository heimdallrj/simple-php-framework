<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Relay\Relay;
use FastRoute\RouteCollector;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

use App\Controllers\Home;
use App\Controllers\Hello;

use Middlewares\FastRoute;
use Middlewares\RequestHandler;

use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

// Route Definitions
$containerBuilder->addDefinitions(
  [
    Home::class => create(Home::class)->constructor(
      get('Foo'), get('Response')
    ),
    'Foo' => 'bar',
    'Response' => function() {
        return new Response();
    },
    Hello::class => create(Hello::class)->constructor(
      get('Response')
    ),
    'Response' => function() {
        return new Response();
    }
  ]
);

$container = $containerBuilder->build();

// Routes
$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/', Home::class);
    $r->get('/hello', Hello::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);
