<?php namespace MW;

/**
 * Class Controller
 * @package MW
 */
class Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * Controller constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function execute()
    {
        return $this->response;    
    }
}
