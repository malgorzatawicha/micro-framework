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

    /**
     * @param Request $request
     * @return string|null
     */
    public function execute(Request $request)
    {
        foreach ($this->routes as $route => $controllerName) {
            if ($this->match($route, $request)){
                return $controllerName;
            }
        }
        return null;
    }

    /**
     * @param $route
     * @param Request $request
     * @return bool
     */
    private function match($route, Request $request)
    {
        if (!strpos($route, '@')) {
            return $this->matchPattern($route, $request);
        }

        list($httpMethod, $pattern) = explode('@', $route);
        if ($this->testRequestAgainstHttpMethod($httpMethod, $request)) {
            return $this->matchPattern($pattern, $request);
        }
        return false;
    }

    /**
     * @param $httpMethod
     * @param Request $request
     * @return bool
     */
    private function testRequestAgainstHttpMethod($httpMethod, Request $request)
    {
        $method = 'is' . ucfirst($httpMethod);
        return (method_exists($request, $method) && $request->$method());
    }

    /**
     * @param $pattern
     * @param Request $request
     * @return bool
     */
    private function matchPattern($pattern, Request $request)
    {
        return preg_match('/^' . $pattern . '$/', $request->getUri()) == 1;
    }
}
