<?php

namespace App\Controller;

use App\Core\Controller;

class RequestController extends Controller
{
    public function call_show_entries()
    {
        echo "Hello from call_show_entries method";
        
        $request_model_obj = $this->load_model_obj('RequestModel');
        $request_model_obj->show_entries();

    }

    public function display_request_form()
    {
        // $request_model_obj = $this->load_model_obj('RequestModel');
        // $request_model_obj->show_entries();
        // $this->model('')
        $this->view('request' . DIRECTORY_SEPARATOR . 'index');
        $this->view_title = 'Request form';
        $this->view->render();
    }
}