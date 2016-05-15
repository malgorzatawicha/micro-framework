<?php namespace MW;

/**
 * Class ControllerWithView
 * @package MW
 */
class ControllerWithView extends Controller
{
    protected $view;
    public function __construct(Request $request, Response $response, View $view)
    {
        parent::__construct($request, $response);
        $this->view = $view;
    }
}
