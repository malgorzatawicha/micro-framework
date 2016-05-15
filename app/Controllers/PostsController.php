<?php namespace App\Controllers;

use MW\Controller;

class PostsController extends Controller
{
    public function listAction()
    {
        return $this->response->setContent('List posts');
    }
}
