<?php declare(strict_types = 1);

class Bootstrap
{
    /**
     * Инициализация
     */
    public static function init()
    {
        defined('ROOT_PATH') || define('ROOT_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
        require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

        defined('DI_CONTAINER_PATH') || define('DI_CONTAINER_PATH', ROOT_PATH . '/var/cache/di/container.php');
        defined('DI_CONFIG_PATH') || define('DI_CONFIG_PATH', ROOT_PATH . '/etc/di');

        require_once DI_CONTAINER_PATH;
    }
}

Bootstrap::init();
