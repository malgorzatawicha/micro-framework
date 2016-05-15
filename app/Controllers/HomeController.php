<?php namespace App\Controllers;

use MW\Controller;

class HomeController extends Controller
{
    public function welcome()
    {
        return $this->response->setContent('Welcome');
    }
}
