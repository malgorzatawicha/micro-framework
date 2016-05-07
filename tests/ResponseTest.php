<?php namespace Tests;


use MW\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    private function getOutputMock()
    {
        return $this->getMockBuilder('\MW\Output')
            ->setMethods(['header', 'content'])
            ->getMock();
    }
    public function testClassExists()
    {
        $response = new Response($this->getOutputMock());
        $this->assertInstanceOf('\MW\Response', $response);
    }
    
    public function testSend()
    {
        $output = $this->getOutputMock();
        $output->expects($this->once())->method('header')->with('HTTP/1.0 200 OK');
        $output->expects($this->once())->method('content')->with('');
        $response = new Response($output);
        $response->send();
    }

    public function testSendNotEmptyContent()
    {
        $output = $this->getOutputMock();
        $output->expects($this->once())->method('header')->with('HTTP/1.0 200 OK');
        $output->expects($this->once())->method('content')->with('Not Empty');
            
        $response = new Response($output);
        $response->setContent('Not Empty')->send();
    }

    public function testSendNotFound()
    {
        $output = $this->getOutputMock();
        $output->expects($this->once())->method('header')->with('HTTP/1.0 404 Not Found');
        $output->expects($this->once())->method('content')->with('Not Empty');

        $response = new Response($output);
        $response->setContent('Not Empty')->setStatus(404)->send();
    }

    public function testSendCustomHeader()
    {
        $output = $this->getOutputMock();
        $output->expects($this->at(0))->method('header')->with('CustomHeader: dummy');
        $output->expects($this->at(1))->method('header')->with('HTTP/1.0 200 OK');
        $output->expects($this->once())->method('content')->with('Not Empty');

        $response = new Response($output);
        $response->setContent('Not Empty')->setHeaders(['CustomHeader' => 'dummy'])->send();
    }
}