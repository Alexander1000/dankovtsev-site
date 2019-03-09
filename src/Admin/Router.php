<?php declare(strict_types = 1);

namespace Admin;

/**
 * @router etc/routes/admin.yml
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
            $this->routes = include(ROOT_PATH . '/var/cache/routes/Admin_Router.php');
        }
        return $this->routes;
    }
}
