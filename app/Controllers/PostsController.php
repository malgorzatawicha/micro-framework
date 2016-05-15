<?php namespace App\Controllers;

use App\Models\Post;
use MW\ControllerWithView;
use MW\Request;
use MW\Response;
use MW\View;

class PostsController extends ControllerWithView
{
    private $postModel;
    public function __construct(Request $request, Response $response, View $view, Post $postModel)
    {
        parent::__construct($request, $response, $view);
        $this->postModel = $postModel;
    }

    public function listAction()
    {
        return $this->view->template('posts/list.html.php')->with(['posts' => $this->postModel->get()]);
    }
}
