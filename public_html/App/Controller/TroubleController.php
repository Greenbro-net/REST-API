<?php

namespace App\Controller;

use App\Core\Controller;

class TroubleController extends Controller
{
     public function page_404()
     {
         $this->model('TroubleModel');
         $this->view('trouble' . DIRECTORY_SEPARATOR . 'index');
         $this->view->page_title = "404 Сторінка не знайдена";
         $this->view->render();
     }
}
