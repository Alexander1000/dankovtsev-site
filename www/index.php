<?php declare(strict_types = 1);

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$container = new DI\CachedContainer();

$app = new Beauty\App($container);

$request = new Beauty\Request(
    $_GET,
    $_POST,
    $_COOKIE,
    $_SERVER,
    $_FILES
);

/** @var Beauty\RouterInterface $router */
$router = $container->get(Router::class);
$router->setContainer($container);

try {
    $app->process($router, $request)->reply();
} catch (Beauty\Exception\NotFound $e) {
        var_dump($e->getMessage(), $e->getFile(), $e->getLine());
    (new Controller\Errors($request))
        ->notFound()
        ->reply();
} catch (Throwable $e) {
    var_dump($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    exit;
    (new Controller\Errors($request))
        ->internalError()
        ->reply();
}
