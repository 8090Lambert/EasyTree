<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/4
 */

namespace Lambert\TreeShape;

use Lambert\TreeShape\Contracts\BaseTree;

class Tree extends BaseTree
{
    /**
     * @var array
     */
    protected $childrenIds;

    /**
     * @var array
     */
    protected $recursionChildrenIds;

    /**
     * CategoryTree constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->currentNode = new Node($data);
    }

    /**
     * @param $id
     * @return $this
     */
    public function setChildrenId($id)
    {
        $this->childrenIds[] = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getChildrenIds()
    {
        return is_null($this->childrenIds) ? [] : $this->childrenIds;
    }

    /**
     * @return array
     */
    public function getAllChildrenIds()
    {
        if (is_null($this->recursionChildrenIds)) {
            $this->recursionChildrenIds($this->getRightTree());
        }

        return $this->recursionChildrenIds;
    }

    /**
     * @param array $trees
     */
    protected function recursionChildrenIds(array $trees)
    {
        if (!empty($trees)) {
            foreach ($trees as $tree) {
                $this->recursionChildrenIds[] = $tree->getCurrentNode()->getId();
                $this->recursionChildrenIds((array)$tree->getRightTree());
            }
        }
    }
}
