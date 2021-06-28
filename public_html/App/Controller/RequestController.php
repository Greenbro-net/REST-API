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

    public function grab_product()
    {
        $request_model_obj = $this->load_model_obj('RequestModel');
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

    public function prepare_request()
    {
        if (!empty($_GET['id_category'])) {
            $id_category = $_GET['id_category'];
            
            header("Location:" . "http://example.com/request/grab_product/$id_category");
            exit;
        } else {
            header("Location:" . "http://example.com/?error_message=Error is happened, try again"); // error case
            exit;
               }
    }
}