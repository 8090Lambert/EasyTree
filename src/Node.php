<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/5
 */

namespace Lambert\TreeShape;

use ArrayAccess;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;
use Lambert\TreeShape\Contracts\BaseNode;

class Node extends BaseNode implements ArrayAccess, JsonSerializable, IteratorAggregate
{
    /**
     * @return int
     */
    public function getId()
    {
        return isset($this->data['id']) ? $this->data['id'] : 0;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset) {
            $this->data[$offset] = $value;
        } else {
            $this->data[] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }

    /**
     * @param $id
     * @return mixed|null
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}
