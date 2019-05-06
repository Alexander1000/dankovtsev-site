<?php declare(strict_types = 1);

require_once __DIR__ . '/src/bootstrap.php';

$container = new \DI\CachedContainer();

$controller = $container->get(\Admin\Controller\Main::class);

var_dump($controller->indexAction());
