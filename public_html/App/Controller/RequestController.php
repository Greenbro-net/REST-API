<?php

namespace App\Controller;

use App\Core\Controller;

class RequestController extends Controller
{
    public $id_category;

    public $id_brand;
    public $id_availability;
    public $item_price_from;
    public $item_price_to;
    public $price_sorting_order;
    public $sorting_order;


    public function __construct()
    {
        $this->id_category = !empty($_GET['id_category']) ? $this->filter_data($_GET['id_category']) : false;
        $this->id_brand = !empty($_GET['id_brand']) ? $this->filter_data($_GET['id_brand']) : false;
        $this->id_availability = !empty($_GET['id_availability']) ? $this->filter_data($_GET['id_availability']) : false;
        $this->item_price_from = !empty($_GET['item_price_from']) ? $this->filter_data($_GET['item_price_from']) : false;
        $this->item_price_to = !empty($_GET['item_price_to']) ? $this->filter_data($_GET['item_price_to']) : false;
        $this->price_sorting_order = !empty($_GET['price_sorting_order']) ? $this->filter_data($_GET['price_sorting_order']) : false;
        $this->sorting_order = !empty($_GET['sorting_order']) ? $this->filter_data($_GET['sorting_order']) : false;
    }

    private function filter_data($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function call_show_entries()
    {
        // echo "Hello from call_show_entries method";
        
        $request_model_obj = $this->load_model_obj('RequestModel');
        $request_model_obj->show_entries();

    }

    public function grab_product()
    {
       
        // the code below throw back url to ajax-deletion
        if (empty($_GET['sorting']['sort_by'])) { // error case
            $form_data['posted'] = "Value of sorting was empty";
            $form_data['success'] = false;
            echo json_encode($form_data);
        } elseif(empty($_GET['price']['item_price_from']) || empty($_GET['price']['item_price_to'])) { // error case
            $form_data['posted'] = "Value of price was empty";
            $form_data['success'] = false;
            echo json_encode($form_data);
        } else {
            $request_model_obj = $this->load_model_obj('RequestModel');
            $request_controller_obj = new RequestController;
            $form_data['array'] = $request_model_obj->grab_catalog_data($request_controller_obj);
            
            // the code below for fetching filtered quantity
            $filtered_quantity = $request_model_obj->grab_total_filtered_rows_quantity($request_controller_obj);
            $form_data['array'] = array_merge($form_data['array'], $filtered_quantity);
            // the code below for fetching total quantity
            $total_quantity = $request_model_obj->grab_total_rows_quantity();
            $form_data['array'] = array_merge($form_data['array'], $total_quantity);

            $form_data['success'] = true;
            $form_data['posted'] = 'Data was fetched successfully';
            echo json_encode($form_data);
               }
         
        

    }

    public function display_request_form()
    {
        $this->view('request' . DIRECTORY_SEPARATOR . 'index');
        $this->view_title = 'Request form';
        $this->view->render();
    }

    public function prepare_request()
    {
        if (!empty($_GET['id_category'])) {
            $id_category = $_GET['id_category'];
            
            header("Location:" . "http://example.com/request/display_request_form/$id_category");
            exit;
        } else {
            header("Location:" . "http://example.com/?error_message=Error is happened, try again"); // error case
            exit;
               }
    }
}