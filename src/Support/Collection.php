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
    
    public function toArray()
    {
        return $this->elements;
    }
    
    public function removeAllSuchThatMethod(callable $block)
    {
        foreach ($this->elements as $key => $value) {
            if ($block($key, $value)) {
                unset($this->elements[$key]);
            }
        }
        $this->reindex();
    }

    public function clear()
    {
        $this->elements = [];    
    }

    public function remove($value)
    {
        while($this->includes($value)) {
            $index = $this->findIndex($value);
            unset($this[$index]);
        }
        $this->reindex();
    }
    
    public function removeAll(Collection $collection)
    {
        foreach ($collection as $element) {
            $this->remove($element);
        }
    }
    
    public function add($value)
    {
        $this->elements[] = $value;
    }
    
    public function select(callable $block)
    {
        $result = new Collection();
        foreach ($this->elements as $key => $value) {
            if ($block($key, $value)) {
                $result->add($value);
            }
        }
        return $result;
    }

    public function reject(callable $block)
    {
        $result = new Collection();
        foreach ($this->elements as $key => $value) {
            if (!$block($key, $value)) {
                $result->add($value);
            }
        }
        return $result;
    }
    
    public function collect(callable $block)
    {
        $result = new Collection();
        foreach ($this->elements as $key => $value) {
            $result->add($block($key, $value));
        }
        return $result;
    }
    
    public function copy()
    {
        $result = new Collection();
        foreach ($this->elements as $key => $value) {
            $result->add($value);
        }
        return $result;
    }
    
    public function copyWith($value)
    {
        $result = $this->copy();
        $result->add($value);
        return $result;
    }

    public function copyWithout($value)
    {
        $result = $this->copy();
        $result->remove($value);
        return $result;
    }
    
    public function copyReplacing($targetValue, $withValue)
    {
        $result = $this->copy();
        foreach ($result as $key => $value) {
            if ($value == $targetValue) {
                $result[$key] = $withValue;
            }
        }
        return $result;
    }
    
    public function join(Collection $collection)
    {
        $result = $this->copy();
        foreach ($collection as $element) {
            $result->add($element);
        }
        return $result;
    }
    
    private function reindex()
    {
        $this->elements = array_values($this->elements);
    }
    
    private function findIndex($value)
    {
        return array_search($value, $this->elements);
    }
}
