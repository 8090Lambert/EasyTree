<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/5
 */

namespace Lambert\TreeShape;

use RuntimeException;

class Manager
{
    /**
     * @var bool
     */
    protected $findRelation = false;

    /**
     * @var array
     */
    protected $relationTree;

    /**
     * @var array
     */
    protected $relationKeys = [];

    /**
     * Original Attribute Relation Column
     * @var string
     */
    protected $relationColumn;

    /**
     * Manager constructor.
     * @param string $relationColumn
     */
    protected function __construct($relationColumn)
    {
        $this->relationColumn = $relationColumn;
    }

    /**
     * start build
     * @param array $attributes
     * @return $this
     */
    protected function startBuild(array $attributes)
    {
        $tree = [];
        foreach ($attributes as $item) {
            if (empty($tree)) {
                $currentTree = new Tree($item);
                $tree[$currentTree->getCurrentNode()->getId()] = $currentTree;
            } else {
                $tree = $this->setRelation($tree, $item, $item[$this->relationColumn]);
            }
        }
        $this->relationTree = $tree;

        return $this;
    }

    /**
     * @param array $attributes
     * @param string $relationColumn
     * @return mixed
     */
    public static function buildTree(array $attributes, $relationColumn = 'pid')
    {
        if (!array_column($attributes, $relationColumn)) {
            throw new RuntimeException('Original attributes each node must have $relationColumn');
        }
        return (new static($relationColumn))->startBuild($attributes);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->relationTree;
    }

    /**
     * @param array $trees
     * @param array $data
     * @param int $id
     * @return array
     */
    protected function setRelation(array $trees, array $data, $id)
    {
        $this->findRelation = false;
        if (!empty($trees)) {
            $trees = $this->relations($trees, $data, $id);
            if ($this->findRelation === false) {
                $currentTree = new Tree($data);
                $trees[$currentTree->getCurrentNode()->getId()] = $currentTree;
            }
        }

        return $trees;
    }

    /**
     * @param array $trees
     * @param array $data
     * @param int $id
     * @return array
     */
    protected function relations(array $trees, array $data, $id)
    {
        foreach ($trees as $key => $tree) {
            if ($tree->getCurrentNode()->getId() == $id) {
                $rightTree = new Tree($data);
                $trees[$key]->setChildrenId($rightTree->getCurrentNode()->getId())->setRightTree($rightTree);
                $rightTree->setLeftTree($trees[$key]);
                $this->findRelation = true;
                break;
            } else {
                $this->relations((array)$tree->getRightTree(), $data, $id);
            }
        }

        return $trees;
    }

    /**
     * @param $field
     * @param $value
     * @return array|mixed
     */
    public function findTree($field, $value)
    {
        return $this->recursionFindTree($this->relationTree, $field, $value);
    }

    /**
     * @param array $trees
     * @param string $field
     * @param string|int $value
     * @return Tree|null
     */
    public function recursionFindTree(array $trees, $field, $value)
    {
        $tree = null;
        if (!empty($trees)) {
            foreach ($trees as $key => $item) {
                if ($item->getCurrentNode()->{$field} != $value) {
                    $tree = $this->recursionFindTree((array) $item->getRightTree(), $field, $value);
                    if (!empty($tree)) {
                        break;
                    }
                } else {
                    $tree = $item;
                    break;
                }
            }
        }

        return $tree;
    }

}
