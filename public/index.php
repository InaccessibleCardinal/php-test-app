<?php 
declare(strict_types = 1);

require_once __DIR__.'/../vendor/autoload.php';

use App\DotEnv;
use App\router\Router;
use App\http\IncomingRequest;
use App\http\ServerResponse;
use App\service\InputService;
use App\di\ConfigureContainer;

(new DotEnv('../.env'))->load();

$container = ConfigureContainer::create();

$router = new Router();
$req = new IncomingRequest($_SERVER, new InputService());
$res = new ServerResponse();

$router->get('/', 'App\controller\UiController::handleHome');
$router->get('/signup', 'App\controller\UiController::handleSignup');
$router->get('/signup-success', 'App\controller\UiController::handleSignupSuccess');


$signupPostController = $container->getInstance(App\controller\SignupPostController::class);
$router->post('/signup', [$signupPostController, 'handleSignup']);
$router->get('/introspect-users', [$signupPostController, 'handleIntrospect']);

$loginController = $container->getInstance(App\controller\LoginController::class);
$router->get('/login', [$loginController, 'handleGetLogin']);
$router->post('/login', [$loginController, 'handlePostLogin']);

$remoteUsersController = $container->getInstance(App\controller\RemoteUsersController::class);
$router->get('/remote-users', [$remoteUsersController, 'handleGet']);
$router->post('/remote-users', [$remoteUsersController, 'handlePost']);


$router->get('/test', function() use ($req) {
  echo json_encode($req, JSON_PRETTY_PRINT);
});

$router->execute($req, $res);
