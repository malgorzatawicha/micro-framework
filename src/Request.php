<?php namespace MW;

/**
 * Class Request
 * @package MW
 */
class Request
{
    /**
     * @var array
     */
    private $query;

    /**
     * @var array
     */
    private $input;
    /**
     * Request constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->query = isset($data['_GET'])?$data['_GET']:[];
        $this->input = isset($data['_POST'])?$data['_POST']:[];
    }

    /**
     * @return array|mixed
     */
    private function all()
    {
        return $this->query + $this->input;
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
}