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
}
