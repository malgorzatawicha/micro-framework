<?php namespace MW\Support;

class Collection implements \ArrayAccess, \Iterator
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
    
    public function size()
    {
        return count($this->elements);
    }
    
    public function occurrencesOf($value)
    {
        $countedValues = array_count_values($this->elements);
        return isset($countedValues[$value])?$countedValues[$value]:0;
    }
    
    public function isEmpty()
    {
        return $this->size() == 0;
    }
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    public function includes($value) 
    {
        return false !== array_search($value, $this->elements);    
    }

    public function current()
    {
        return current($this->elements);
    }

    public function next()
    {
        return next($this->elements);
    }

    public function key()
    {
        return key($this->elements);
    }

    public function valid()
    {
        $key = key($this->elements);
        return ($key !== null && $key !== false);
    }

    public function rewind()
    {
        return reset($this->elements);
    }
    
    public function includesAnyOf(Collection $collection)
    {
        foreach ($collection as $element) {
            if ($this->includes($element)) {
                return true;
            }
        }
        return false;
    }
}
