<?php namespace Tests;


use MW\DependencyInjectionContainer;

class DependencyInjectionContainerTest extends BaseTest
{
    public function testClassExists()
    {
        $di = new DependencyInjectionContainer();
        $this->assertInstanceOf('\MW\DependencyInjectionContainer', $di);
    }
    
    public function testCanAddService()
    {
        $di = new DependencyInjectionContainer();
        $result = $di->addService('dummy', function(){});
        $this->assertTrue($result);
    }
    
    public function testCanGetExistingService()
    {
        $di = new DependencyInjectionContainer();
        $di->addService('dummy', function(){return 'existing1'; });
        
        $result = $di->getService('dummy');
        $this->assertEquals('existing1', $result);
    }

    public function testCanGetServiceSecondTimeDoesNotCreateService()
    {
        $di = new DependencyInjectionContainer();
        $di->addService('dummy', function(){
            static $counter = 0;
            return ++$counter;
        });

        $result = $di->getService('dummy');
        $this->assertEquals(1, $result);
        $result = $di->getService('dummy');
        $this->assertEquals(1, $result);
    }

    public function testNewInstanceCreatesNewService()
    {
        $di = new DependencyInjectionContainer();
        $di->addService('dummy', function(){
            static $counter = 0;
            return ++$counter;
        });

        $result = $di->getNewService('dummy');
        $this->assertEquals(1, $result);
        $result = $di->getNewService('dummy');
        $this->assertEquals(2, $result);
    }
    
    public function testGetNonExistingService()
    {
        $di = new DependencyInjectionContainer();
        $di->addService('dummy', function(){ return 'exists'; });
        
        $result = $di->getService('nonExisting');
        $this->assertNull($result);
    }

    public function testNewInstanceOfNonExistingService()
    {
        $di = new DependencyInjectionContainer();
        $di->addService('dummy', function(){ return 'exists'; });

        $result = $di->getNewService('nonExisting');
        $this->assertNull($result);
    }
}
