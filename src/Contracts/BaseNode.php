<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/4
 */

namespace Lambert\TreeShape\Contracts;

abstract class BaseNode
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Node constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
