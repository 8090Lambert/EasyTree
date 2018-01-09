<?php
/**
 * Created by PhpStorm.
 * User: 8090Lambert
 * Date: 2018/1/8
 */

namespace Lambert\TreeShape\Tests;

use Mockery;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}