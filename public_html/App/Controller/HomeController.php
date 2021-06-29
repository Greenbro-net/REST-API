<?php

namespace App\Controller;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home' . DIRECTORY_SEPARATOR . 'index');
        $this->view->page_title = 'Start a request';
        $this->view->render();
    }
}