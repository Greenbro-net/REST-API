<?php

namespace App\Controller;

use App\Core\Controller;
use Exception;

class QueryController extends Controller
{
    public $query;
    public $request_controller_obj;


    public $create_id_brand_state;
    public $create_id_category_state;
    public $create_id_availability_state;
    public $create_coverage_price_state;


    public $id_category;
    public $id_brand;
    public $item_price_from;
    public $item_price_to;

    public $id_ivailability;
    public $price_name_sorting_order;
    public $sorting_order;



    public function __construct($request_controller_obj)
    {
        $this->request_controller_obj = $request_controller_obj;

        
        $this->id_brand = $request_controller_obj->id_brand;
        $this->id_category = $request_controller_obj->id_category;
        $this->id_availability = $request_controller_obj->id_availability;
        $this->item_price_from = $request_controller_obj->item_price_from;
        $this->item_price_to = $request_controller_obj->item_price_to;


        
        $this->create_coverage_price_state = $this->create_coverage_price_state($this->item_price_from, $this->item_price_to);
        $this->create_id_category_state = $this->create_id_category_state($this->id_category);
        $this->create_id_availability_state = $this->create_id_availability_state($this->id_availability);
        $this->create_id_brand_state = $this->create_id_brand_state($this->id_brand);

        
        $this->price_name_sorting_order = $request_controller_obj->price_name_sorting_order;
        $this->sorting_order = $request_controller_obj->sorting_order;
    }

    public function make_query()
    {
        
        $query = "WITH current_price AS ( 
            SELECT catalog.id, catalog.name, id_brand, catalog.id_category, id_availability, price, id_currency, 
            SUM(catalog_currencies.rate * catalog.price) AS price_in_uah from catalog,catalog_currencies 
            WHERE catalog.id_currency = catalog_currencies.id AND
            $this->create_id_availability_state
            $this->create_id_brand_state
    
            GROUP BY catalog.id) 
            SELECT * FROM current_price 
            WHERE current_price.id_category $this->create_id_category_state 
            $this->create_coverage_price_state
            
            GROUP BY $this->price_name_sorting_order $this->sorting_order";
    
            return $query;
        
    }

    public function make_filtered_total_query()
    {
        $query = "SELECT COUNT(*) as totalNumberOfFilteredItems FROM catalog 
        WHERE 
            $this->create_id_availability_state
            $this->create_id_brand_state
            AND catalog.id_category   $this->create_id_category_state";

        return $query;
    }

    public function make_total_query()
    {
        $query = "SELECT COUNT(*) as totalQuantityOfGoods FROM catalog";

        return $query;
    }

    public function create_id_availability_state( string $id_ivailability)
    {   
        try {
            if (!(is_string($id_ivailability))) {
                throw new Exception("Method create_id_availability_state hasn't got right argument");
            }
            if ($id_ivailability == 'all') {
                return " catalog.id_availability IS NOT NULL";
            } else {
                return " catalog.id_availability = $id_ivailability";
                   }
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }

    public function create_id_category_state( string $id_category)
    {
        try {
            if (!(is_string($id_category))) {
                throw new Exception("Method create_id_category_state hasn't got right argument");
            }
            if ($id_category == 'all') {
                return " IS NOT NULL";
            } else {
                return " = $id_category";
                   }
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    public function create_id_brand_state( string $id_brand)
    {
        try {
            if (!(is_string($id_brand))) {
                throw new Exception("Method create_id_brand_state hasn't got right argument");
            }
            if ($id_brand == 'all') {
                return " AND catalog.id_brand IS NOT NULL";
            } else {
                return " AND catalog.id_brand = $id_brand";
                   }
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
    
    public function create_coverage_price_state( $item_price_from,  $item_price_to)
    {
        try {
            if (empty($item_price_from) || empty($item_price_to)) {
                throw new Exception("Method create_coverage_price_state hasn't got right arguments");
            }
            
                return " AND current_price.price_in_uah BETWEEN $item_price_from AND $item_price_to";
                
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }
}     