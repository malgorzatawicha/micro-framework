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
     * @param $uri
     * @return bool
     */
    public function match($uri)
    {
        return preg_match("/^" . $this->pattern . "$/", $uri) == 1;
    }

    /**
     * @return string
     */
    public function getControllerClass()
    {
        return $this->controller;
    }
}