<?php namespace MW\Support;

class Collection implements \ArrayAccess
{
    private $elements;
    
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->elements);
    }

    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->elements[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }
}
