<?php declare(strict_types = 1);

/**
 * @router etc/routes/site.yml
 */
class Router extends \Beauty\Router
{
    protected $routes;

    /**
     * @inheritdoc
     */
    public function getRoutes(): array
    {
        if (!$this->routes) {
            $this->routes = include(ROOT_PATH . '/var/cache/routes/Router.php');
        }
        return $this->routes;
    }
}
