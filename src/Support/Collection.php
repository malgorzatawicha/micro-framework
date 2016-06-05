<?php namespace MW\Support;

/**
 * Class Collection
 * @package MW\Support
 */
class Collection implements \ArrayAccess, \Iterator
{
    /**
     * @var array
     */
    private $elements;

    /**
     * Collection constructor.
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->elements);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->elements[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->elements[$offset]);
    }

    /**
     * @return int
     */
    public function size()
    {
        return count($this->elements);
    }

    /**
     * @param $value
     * @return int
     */
    public function occurrencesOf($value)
    {
        $countedValues = array_count_values($this->elements);
        return isset($countedValues[$value])?$countedValues[$value]:0;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->size() == 0;
    }

    /**
     * @return bool
     */
    public function isNotEmpty()
    {
        return !$this->isEmpty();
    }

    /**
     * @param $value
     * @return bool
     */
    public function includes($value) 
    {
        return false !== array_search($value, $this->elements);    
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->elements);
        return ($key !== null && $key !== false);
    }

    /**
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->elements);
    }

    /**
     * @param Collection $collection
     * @return bool
     */
    public function includesAnyOf(Collection $collection)
    {
        foreach ($collection as $element) {
            if ($this->includes($element)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * @param callable $block
     */
    public function removeAllSuchThatMethod(callable $block)
    {
        foreach ($this->elements as $key => $value) {
            if ($block($key, $value)) {
                unset($this->elements[$key]);
            }
        }
        $this->reindex();
    }

    /**
     *
     */
    public function clear()
    {
        $this->elements = [];    
    }

    /**
     * @param $value
     */
    public function remove($value)
    {
        while($this->includes($value)) {
            $index = $this->findIndex($value);
            unset($this[$index]);
        }
        $this->reindex();
    }

    /**
     * @param Collection $collection
     */
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

    public function addAll(Collection $collection)
    {
        foreach ($collection as $element) {
            $this->add($element);
        }
    }
    
    public function unique()
    {
        $collection = (new Collection(array_unique($this->toArray())));
        $collection->reindex();
        return $collection;
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
