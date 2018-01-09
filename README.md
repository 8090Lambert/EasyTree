# EasyTree

 
> 生成树形结构的简单方式

## Feature 

有Relation_key的关系数据，都可以生成树状的结构

## RequireMent

- PHP >= 5.6

## Usage

```
use Lambert\TreeShape\Manager;
 
$category = [
    ['id' => 1, 'name' => '节点1', 'pid' => 0],
    ['id' => 2, 'name' => '节点2', 'pid' => 0],
    ['id' => 3, 'name' => '节点3', 'pid' => 1],
    ['id' => 4, 'name' => '节点4', 'pid' => 1],
];
 
// Start build
$manager = Manager::buildTree($category, 'pid');
$tree = $manager->all();
```
生成后：
```
Array
(
    [1] => Lambert\TreeShape\Tree Object
        (
            [childrenIds:protected] => Array
                (
                    [0] => 3
                    [1] => 4
                )

            [recursionChildrenIds:protected] =>
            [currentNode:protected] => Lambert\TreeShape\Node Object
                (
                    [data:protected] => Array
                        (
                            [id] => 1
                            [name] => 节点1
                            [pid] => 0
                        )

                )

            [leftTree:protected] =>
            [rightTree:protected] => Array
                (
                    [3] => Lambert\TreeShape\Tree Object
                        (
                            [childrenIds:protected] =>
                            [recursionChildrenIds:protected] =>
                            [currentNode:protected] => Lambert\TreeShape\Node Object
                                (
                                    [data:protected] => Array
                                        (
                                            [id] => 3
                                            [name] => 节点3
                                            [pid] => 1
                                        )

                                )

                            [leftTree:protected] => Lambert\TreeShape\Tree Object
 *RECURSION*
                            [rightTree:protected] =>
                        )

                    [4] => Lambert\TreeShape\Tree Object
                        (
                            [childrenIds:protected] =>
                            [recursionChildrenIds:protected] =>
                            [currentNode:protected] => Lambert\TreeShape\Node Object
                                (
                                    [data:protected] => Array
                                        (
                                            [id] => 4
                                            [name] => 节点4
                                            [pid] => 1
                                        )

                                )

                            [leftTree:protected] => Lambert\TreeShape\Tree Object
 *RECURSION*
                            [rightTree:protected] =>
                        )

                )

        )

    [2] => Lambert\TreeShape\Tree Object
        (
            [childrenIds:protected] =>
            [recursionChildrenIds:protected] =>
            [currentNode:protected] => Lambert\TreeShape\Node Object
                (
                    [data:protected] => Array
                        (
                            [id] => 2
                            [name] => 节点2
                            [pid] => 0
                        )

                )

            [leftTree:protected] =>
            [rightTree:protected] =>
        )

)
```

## Methods 

- 查找某个Tree
```
$tree = $manager->findTree('name', '子节点1');
 
Lambert\TreeShape\Tree Object
(
    [childrenIds:protected] => Array
        (
            [0] => 3
            [1] => 4
        )

    [recursionChildrenIds:protected] =>
    [currentNode:protected] => Lambert\TreeShape\Node Object
        (
            [data:protected] => Array
                (
                    [id] => 1
                    [name] => 节点1
                    [pid] => 0
                )

        )

    [leftTree:protected] =>
    [rightTree:protected] => Array
        (
            [3] => Lambert\TreeShape\Tree Object
                (
                    [childrenIds:protected] =>
                    [recursionChildrenIds:protected] =>
                    [currentNode:protected] => Lambert\TreeShape\Node Object
                        (
                            [data:protected] => Array
                                (
                                    [id] => 3
                                    [name] => 节点3
                                    [pid] => 1
                                )

                        )

                    [leftTree:protected] => Lambert\TreeShape\Tree Object
*RECURSION*
                    [rightTree:protected] =>
                )

            [4] => Lambert\TreeShape\Tree Object
                (
                    [childrenIds:protected] =>
                    [recursionChildrenIds:protected] =>
                    [currentNode:protected] => Lambert\TreeShape\Node Object
                        (
                            [data:protected] => Array
                                (
                                    [id] => 4
                                    [name] => 节点4
                                    [pid] => 1
                                )

                        )

                    [leftTree:protected] => Lambert\TreeShape\Tree Object
*RECURSION*
                    [rightTree:protected] =>
                )

        )

)
```

- 获取当前树的左、右子树
```
$leftTree = $tree->getLeftTree();
$rightTree = $tree->getRightTree();
Lambert\TreeShape\Tree Object
(
    [childrenIds:protected] => Array
        (
            [0] => 3
            [1] => 4
        )

    [recursionChildrenIds:protected] =>
    [currentNode:protected] => Lambert\TreeShape\Node Object
        (
            [data:protected] => Array
                (
                    [id] => 1
                    [name] => 节点1
                    [pid] => 0
                )

        )

    [leftTree:protected] =>
    [rightTree:protected] =>
)

**注意：获取右子树时，根据自己数据类型的关系，多个右子树的话，会返回Array**
```

- 获取节点属性
```
继承了SPL的ArrayAccess，可以使用数组或属性的方式访问
 
$node = $tree->getCurrentNode();
 
$node['name'] or $node->name;   // 节点1
 
$node['id'] or $node->id;   // 1
...
```

## License

MIT