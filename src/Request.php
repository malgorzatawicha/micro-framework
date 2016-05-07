<?php namespace MW;

/**
 * Class Request
 * @package MW
 */
class Request
{
    /**
     * @var RequestValue
     */
    private $requestValue;

    /**
     * Request constructor.
     * @param RequestValue $requestValue
     */
    public function __construct(RequestValue $requestValue)
    {
        $this->requestValue = $requestValue;
    }

    /**
     * @return array|mixed
     */
    private function all()
    {
        return $this->requestValue->get() + $this->requestValue->post();
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        $value = $this->$name;
        return !is_null($value);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $data = $this->all();
        if (array_key_exists($name, $data)) {
            return $data[$name];
        }
        return null;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return trim($this->requestValue->requestUri(), '/');
    }
}