<?php namespace MW\Support;

trait Iterable
{
    /**
     * @var array
     */
    protected $elements;

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
        $key = $this->key();
        return ($key !== null && $key !== false);
    }

    /**
     * @return mixed
     */
    public function rewind()
    {
        return reset($this->elements);
    }

}
