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
    
    public function testCanChangeElementOfCollection()
    {
        $class = new Collection([1, 2, 3]);
        $class[1] = 5;
        $this->assertEquals(5, $class[1]);
    }

    public function testCanCheckOffset()
    {
        $class = new Collection([1, 2, 3]);
        $this->assertTrue(isset($class[1]));
        $this->assertFalse(isset($class[3]));
    }

    public function testCanDeleteOffset()
    {
        $class = new Collection([1, 2, 3]);
        unset($class[1]);
        $this->assertFalse(isset($class[1]));
    }
    
    public function testSizeMethod()
    {
        $class = new Collection([1, 2, 3]);
        $this->assertEquals(3, $class->size());
    }
    
    public function testOccurencesOfMethod()
    {
        $class = new Collection([1, 2, 3, 2]);
        $this->assertEquals(1, $class->occurrencesOf(3));
        $this->assertEquals(2, $class->occurrencesOf(2));
        $this->assertEquals(0, $class->occurrencesOf(5));
    }
    
    public function testNotEmptyMethod()
    {
        $class = new Collection();
        $this->assertFalse($class->isNotEmpty());

        $class = new Collection([1, 2, 3]);
        $this->assertTrue($class->isNotEmpty());

    }

    public function testEmptyMethod()
    {
        $class = new Collection();
        $this->assertTrue($class->isEmpty());

        $class = new Collection([1, 2, 3]);
        $this->assertFalse($class->isEmpty());
    }
    
    public function testIncludesMethod()
    {
        $class = new Collection([1, 2, 3]);
        $this->assertTrue($class->includes(1));
        $this->assertFalse($class->includes(5));
    }

    public function testCanUseForeachOnCollection()
    {
        $class = new Collection([1, 2, 3]);
        
        $result = [];
        foreach ($class as $key => $value) {
            $result[$key] = $value;
        }
        $this->assertEquals([0 => 1, 1 => 2, 2 => 3], $result);
    }
    
    public function testIncludesAnyOfMethod()
    {
        $class = new Collection([1, 2, 3]);
        $this->assertTrue($class->includesAnyOf(new Collection([2])));
        $this->assertTrue($class->includesAnyOf(new Collection([5, 2])));
        $this->assertFalse($class->includesAnyOf(new Collection([5, 6])));
    }
}
