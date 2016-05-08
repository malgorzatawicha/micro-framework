<?php namespace MW;

class Controller
{
    private $request;
    private $response;
    
    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }
    
    public function execute()
    {
        return $this->response;    
    }
}
