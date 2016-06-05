<?php namespace MW\Support;

/**
 * Class Collection
 * @package MW\Support
 */
class Collection implements \ArrayAccess, \Iterator
{
    use Arrayable, Iterable;

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
        return isset($countedValues[$value]) ? $countedValues[$value] : 0;
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
     * @return $this
     */
    public function removeAllSuchThatMethod(callable $block)
    {
        return $this->filterElementsWith(function($key, $value) use($block){
            return !$block($key, $value);
        })->reindex();
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->elements = [];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function remove($value)
    {
        return $this->filterElementsWith(function($k, $v) use($value) {
            return $v != $value;
        })->reindex();
        
    }

    /**
     * @param Collection $collection
     * @return $this
     */
    public function removeAll(Collection $collection)
    {
        $collection->foreachDo(function($value) {
            $this->remove($value);
        });
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function add($value)
    {
        $this->elements[] = $value;
        return $this;
    }

    /**
     * @param callable $block
     * @return Collection
     */
    public function select(callable $block)
    {
        return (new Collection($this->filterWith($block)))->reindex();
    }

    /**
     * @param callable $block
     * @return Collection
     */
    public function reject(callable $block)
    {
        return (new Collection($this->filterWith(function($key, $value) use($block){
            return !$block($key, $value);
        })))->reindex();
    }

    /**
     * @param callable $block
     * @return Collection
     */
    public function collect(callable $block)
    {
        return new Collection($this->mapWith($block));
    }

    /**
     * @return Collection
     */
    public function copy()
    {
        return new Collection($this->elements);
    }

    /**
     * @param $value
     * @return Collection
     */
    public function copyWith($value)
    {
        return $this->copy()->add($value);
    }

    /**
     * @param $value
     * @return Collection
     */
    public function copyWithout($value)
    {
        return $this->copy()->remove($value);
    }

    /**
     * @param $targetValue
     * @param $withValue
     * @return Collection
     */
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

    /**
     * @param Collection $collection
     * @return Collection
     */
    public function join(Collection $collection)
    {
        return $this->copy()->addAll($collection);
    }

    /**
     * @param Collection $collection
     * @return $this
     */
    public function addAll(Collection $collection)
    {
        $collection->foreachDo(function($value) {
            $this->add($value);
        });
        return $this;
    }

    /**
     * @return Collection
     */
    public function unique()
    {
        return (new Collection(array_unique($this->toArray())))->reindex();
    }

    /**
     *
     */
    private function reindex()
    {
        $this->elements = array_values($this->elements);
        return $this;
    }
    
    /**
     * @param callable $block
     * @return array
     */
    private function filterWith(callable $block)
    {
        return array_filter($this->elements, function($value, $key) use($block) {
            return $block($key, $value);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param callable $block
     */
    private function foreachDo(callable $block)
    {
        array_walk($this->elements, function($value) use($block) {
            $block($value);
        });
    }

    /**
     * @param callable $block
     * @return $this
     */
    private function filterElementsWith(callable $block)
    {
        $this->elements = $this->filterWith($block);
        return $this;
    }

    /**
     * @param callable $block
     * @return array
     */
    private function mapWith(callable $block)
    {
        return array_map(function($key, $value) use($block){
            return $block($key, $value);
        }, array_keys($this->elements), $this->elements);
    }
}
