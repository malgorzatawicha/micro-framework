<?php namespace MW;

/**
 * Class Route
 * @package MW
 */
class Route
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    private $controller;

    /**
     * Route constructor.
     * @param $pattern
     * @param $controller
     */
    public function __construct($pattern, $controller)
    {
        $this->pattern = $pattern;
        $this->controller = $controller;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function match(Request $request)
    {
        return preg_match("/^" . $this->pattern . "$/", $request->getUri()) == 1;
    }

    /**
     * @return string
     */
    public function getControllerClass()
    {
        return $this->controller;
    }
}
