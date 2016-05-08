<?php namespace Tests;

use MW\Controller;

class ControllerTest extends BaseTest
{
    private function getResponseMock()
    {
        $mock = $this->getMockBuilder('\MW\Response')
            ->setConstructorArgs(['output' => $this->getOutputMock()])
            ->getMock();
        return $mock;
    }

    public function testClassExists()
    {
        $controller = new Controller($this->getRequestMock(), $this->getResponseMock());
        $this->assertInstanceOf('\MW\Controller', $controller);
    }

    public function testExecuteReturnsResponse()
    {
        $controller = new Controller($this->getRequestMock(), $this->getResponseMock());
        $this->assertInstanceOf('\MW\Response', $controller->execute());
    }
}
