<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/8
 */

namespace Lambert\TreeShape\Tests;

use RuntimeException;
use Lambert\TreeShape\Manager;
use Lambert\TreeShape\Tree;

class ManagerTest extends TestCase
{

    /**
     * Test stub
     * @var array
     */
    protected $stub = [
        ['id' => 1, 'name' => '父节点1', 'pid' => 0],
        ['id' => 2, 'name' => '父节点2', 'pid' => 0],
        ['id' => 3, 'name' => '子节点3', 'pid' => 1],
        ['id' => 4, 'name' => '子节点4', 'pid' => 1],
        ['id' => 5, 'name' => '子子节点5', 'pid' =>3],
        ['id' => 6, 'name' => '子子节点6', 'pid' =>4],
    ];

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Original attributes each node must have $relationColumn
     */
    public function testBuildTreeWithException()
    {
         Manager::buildTree([['id' => 1], ['id' => 2]]);
    }

    public function testBuildTree()
    {
        $treeManager = Manager::buildTree($this->stub);
        /**
         * @var $tree Tree
         */
        $tree = $treeManager->all()[1];
        $currentNode = $tree->getCurrentNode();
        $this->assertSame(1, $currentNode->id);
        $this->assertSame('父节点1', $currentNode->name);
        $this->assertSame(0, $currentNode->pid);
        $currentNode->test = 'test field';
        $currentNode[] = 'abc';
        $this->assertSame('abc', $currentNode[0]);
        $this->assertSame(true, isset($currentNode['test']));
        unset($currentNode['test'], $currentNode[0]);
        $this->assertSame(false, isset($currentNode['test']));

        foreach ($currentNode as $key => $value) {
            $this->assertSame(true, in_array($key, ['id', 'name', 'pid']));
        }

        $this->assertSame(json_encode($currentNode), json_encode($this->stub[0]));
    }

    public function testFindTree()
    {
        $treeManager = Manager::buildTree($this->stub);
        /**
         * @var $childOne Tree
         */
        $childOne = $treeManager->findTree('name', '子子节点6');
        $this->assertSame(6, $childOne->getCurrentNode()->id);
        $this->assertSame(4, $childOne->getCurrentNode()->pid);

        /**
         * @var $childTwo Tree
         */
        $childTwo = $treeManager->findTree('id', 4);
        $this->assertSame('子节点4', $childTwo->getCurrentNode()->name);
        $this->assertSame(1, $childTwo->getCurrentNode()->pid);

        /**
         * @var $childThree Tree
         */
        $childThree = $childTwo->getLeftTree();
        $this->assertSame(1, $childThree->getCurrentNode()->id);
        $this->assertSame('父节点1', $childThree->getCurrentNode()->name);
    }

    public function testGetChildrenIds()
    {
        $manager = Manager::buildTree($this->stub);
        $this->assertSame([3, 4], $manager->findTree('id', 1)->getChildrenIds());
        $this->assertSame([], $manager->findTree('id', 6)->getChildrenIds());
    }

    public function testGetAllChildrenIds()
    {
        $manager = Manager::buildTree($this->stub);
        $this->assertSame(4, count($manager->findTree('id', 1)->getAllChildrenIds()));
    }
}
