<?php namespace Tests\Support;

use Tests\BaseTest;
use MW\Support\Collection;

class CollectionTest extends BaseTest
{
    public function testClassExists()
    {
        $class = new Collection();
        $this->assertInstanceOf('\MW\Support\Collection', $class);
    }

    public function testCanAccessCollectionAsSimpleArray()
    {
        $class = new Collection([1, 2, 3]);
        $this->assertEquals(1, $class[0]);
        $this->assertEquals(2, $class[1]);
        $this->assertEquals(3, $class[2]);
    }
}
