<?php namespace MW;

class Controller
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function execute()
    {
        
    }
}
