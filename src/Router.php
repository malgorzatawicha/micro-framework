<?php namespace MW;

/**
 * Class Router
 * @package MW
 */
class Router
{
    /**
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function execute(Request $request)
    {
        /** @var Route $route */
        foreach ($this->routes as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }
        return null;
    }
}
