<?php namespace MW;

/**
 * Class RequestValue
 * @package MW
 */
class RequestValue
{
    /**
     * @var array
     */
    private $data;

    /**
     * RequestValue constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function post()
    {
        return isset($this->data['_POST'])?$this->data['_POST']:[];
    }

    /**
     * @return array
     */
    public function get()
    {
        return isset($this->data['_GET'])?$this->data['_GET']:[];
    }

    /**
     * @return string
     */
    public function requestUri()
    {
        if (!isset($this->data['_SERVER'])) {
            return '';        
        }
        if (!isset($this->data['_SERVER']['REQUEST_URI']))
        {
            return '';
        }
        
        return $this->data['_SERVER']['REQUEST_URI'];
    }
}