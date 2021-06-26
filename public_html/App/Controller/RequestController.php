<?php

use App\Core\Controller;

class RequestController extends Controller
{
    public function call_show_entries()
    {
        $request_model_obj = $this->load_model_obj('RequestModel');
        $request_model_obj->show_entries();
    }
}