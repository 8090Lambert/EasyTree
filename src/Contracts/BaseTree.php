<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/4
 */

namespace Lambert\TreeShape\Contracts;

abstract class BaseTree
{
    /**
     * @var array|BaseNode
     */
    protected $currentNode;

    /**
     * @var array|BaseTree
     */
    protected $leftTree;

    /**
     * @var array|BaseTree
     */
    protected $rightTree;

    /**
     * @param BaseTree $tree
     * @return BaseTree
     */
    public function setLeftTree(BaseTree $tree)
    {
        return $this->leftTree = $tree;
    }

    /**
     * @param BaseTree $tree
     * @return BaseTree
     */
    public function setRightTree(BaseTree $tree)
    {
        return $this->rightTree[$tree->getCurrentNode()->getId()] = $tree;
    }

    /**
     * @return array|BaseNode
     */
    public function getCurrentNode()
    {
        return $this->currentNode;
    }

    /**
     * @return array|BaseTree
     */
    public function getLeftTree()
    {
        return $this->leftTree;
    }

    /**
     * @return array|BaseTree
     */
    public function getRightTree()
    {
        if (is_array($this->rightTree) && count($this->rightTree) == 1) {
            return array_slice($this->rightTree, 0, 1);
        } else {
            return $this->rightTree;
        }
    }

    /**
     * @return mixed
     */
    abstract function getChildrenIds();
}
