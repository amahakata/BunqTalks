<?php
use DI\Container;
use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;



define('APP_ROOT',dirname(__DIR__));
require APP_ROOT . '/vendor/autoload.php';
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(APP_ROOT . '/src/definitions.php');
$container = $containerBuilder->build();



AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$errorSettings = $container->get('Config')->getErrorSettings();
$error_middleware = $app->addErrorMiddleware(
    $errorSettings['displayErrorDetails'], 
    $errorSettings['logErrors'], 
    $errorSettings['logErrorDetails']);

$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');
require APP_ROOT . '/middleware/AddJsonResponseHeader.php';
$app->add(new app\middleware\AddJsonResponseHeader);



require_once APP_ROOT . '/routes/user.php';
require_once APP_ROOT . '/routes/group.php';


$app->run();
