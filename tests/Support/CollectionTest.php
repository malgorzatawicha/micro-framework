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
    
    public function testToArrayMethod()
    {
        $class = new Collection([1, 2, 3]);
        $this->assertEquals([1, 2, 3], $class->toArray());        
    }
    
    public function testRemoveAllSuchThatMethod()
    {
        $class = new Collection([2, 1, 2, 3]);
        $class->removeAllSuchThatMethod(function($key, $value) {
           return $value == 2;
        });
        $this->assertEquals([1, 3], $class->toArray());
    }
    
    public function testClear()
    {
        $class = new Collection([1, 2, 3]);
        $class->clear();
        $this->assertTrue($class->isEmpty());
    }

    public function testRemove()
    {
        $class = new Collection([2, 1, 2, 3]);
        $class->remove(2);
        $this->assertEquals([1, 3], $class->toArray());
    }
    
    public function testRemoveAll()
    {
        $class = new Collection([2, 1, 2, 3]);
        $class->removeAll(new Collection([2, 4]));
        $this->assertEquals([1, 3], $class->toArray());
    }
    
    public function testAdd()
    {
        $class = new Collection([1, 2, 3]);
        $class->add(4);
        $this->assertEquals([1, 2, 3, 4], $class->toArray());
    }
    
    public function testSelect()
    {
        $class = new Collection([1, 2, 3]);
        $newCollection = $class->select(function($key, $value) {
            return $value >= 2;
        });

        $this->assertEquals([1, 2, 3], $class->toArray());
        $this->assertInstanceOf('\MW\Support\Collection', $newCollection);
        $this->assertEquals([2, 3], $newCollection->toArray());
    }

    public function testReject()
    {
        $class = new Collection([1, 2, 3, 1]);
        $newCollection = $class->reject(function($key, $value) {
            return $value >= 2;
        });

        $this->assertEquals([1, 2, 3, 1], $class->toArray());
        $this->assertInstanceOf('\MW\Support\Collection', $newCollection);
        $this->assertEquals([1, 1], $newCollection->toArray());
    }
    
    public function testCollect()
    {
        $class = new Collection([1, 2, 3]);
        $newCollection = $class->collect(function($key, $value) {
            return $value*2;
        });
        $this->assertEquals([1, 2, 3], $class->toArray());
        $this->assertInstanceOf('\MW\Support\Collection', $newCollection);
        $this->assertEquals([2, 4, 6], $newCollection->toArray());
    }
}
