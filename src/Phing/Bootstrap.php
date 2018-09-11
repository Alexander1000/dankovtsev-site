<?php declare (strict_types = 1);

namespace Phing;

class Bootstrap extends \Task
{
    /**
     * @inheritdoc
     */
    public function main()
    {
        defined('ROOT_PATH') || define('ROOT_PATH', dirname(dirname(__DIR__)));
        defined('DI_CONTAINER_PATH') || define('DI_CONTAINER_PATH', ROOT_PATH . '/var/cache/di/container.php');
        defined('DI_CONFIG_PATH') || define('DI_CONFIG_PATH', ROOT_PATH . '/etc/di');
    }
}
