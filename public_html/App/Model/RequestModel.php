<?php

namespace App\Model;

use App\Controller\QueryController;
use App\Controller\RequestController;
use PDO;
use Exception;


class RequestModel 
{
    private static $host   = DATABASE_HOST;
    private static $dbName = DATABASE_NAME;
    private static $username = DATABASE_USERNAME;
    private static $password = DATABASE_PASSWORD;

    public $create_id_availability_state;

    public function __construct()
    {
        // $request_controller_obj = new RequestController;
        // TO DO create constructor which sets up values as a string for next execution 
        // $this->create_id_availability_state = create_id_availability_state($request_controller_obj);
    }

    protected static function connect() {
        $pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbName.";charset=utf8", self::$username, self::$password);
        $pdo->setAttribute(PDO::ERRMODE_EXCEPTION, PDO::FETCH_ASSOC);

        return $pdo;
    }
    protected static function query($query, $params = array()) {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }
    }


    

    public  function grab_catalog_data(string $query)
    { 
        try {
        if (!(is_string($query))) {
            throw new Exception("Method grab_catalog_data hasn't got right argument");
        }
           

    $stmt = $this->connect()->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
             if (empty($results)) {
                 throw new Exception("Method grab_catalog_data returns empty results");
                                  } else {
                                    return $results;
                                         }
            } catch (Exception $exception) {
                    file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                      'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    public function grab_total_rows_quantity()
    { 
        try {
        $query = "SELECT COUNT(*) as totalQuantityOfGoods FROM catalog";
    

    $stmt = $this->connect()->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
             if (empty($results)) {
                 throw new Exception("Method grab_total_rows_quantity returns empty results");
                                  }
            } catch (Exception $exception) {
                    file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                      'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    public function grab_total_filtered_rows_quantity(RequestController $request_controller_obj)
    { 
        try {
        $query = "SELECT COUNT(*) as totalNumberOfFilteredItems FROM catalog 
        WHERE id_category = $request_controller_obj->id_category" 
        // . $this->create_id_availability_state($request_controller_obj)
        ;
    

    $stmt = $this->connect()->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
             if (empty($results)) {
                 throw new Exception("Method grab_total_filtered_rows_quantity returns empty results");
                                  }
            } catch (Exception $exception) {
                    file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                      'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    
    

    // $query = "WITH current_price AS ( 
    //     SELECT catalog.id, catalog.name, id_brand,catalog.id_category, id_availability, price, id_currency, 
    //     SUM(catalog_currencies.rate * catalog.price) AS price_in_uah from catalog,catalog_currencies 
    //     WHERE catalog.id_currency = catalog_currencies.id 
    //     GROUP BY catalog.id) SELECT *
    //     FROM current_price 
    //     WHERE current_price.id_category = $request_controller_obj->id_category 
    //     AND current_price.id_availability = $request_controller_obj->id_availability
    //     AND current_price.id_brand = $request_controller_obj->id_brand
    //     GROUP BY $request_controller_obj->price_name_sorting_order $request_controller_obj->sorting_order";

        
    // WITH current_price AS ( 
    //     SELECT catalog.id, catalog.name, id_brand,catalog.id_category, id_availability, price, id_currency, 
    //     SUM(catalog_currencies.rate * catalog.price) AS price_in_uah from catalog,catalog_currencies 
    //     WHERE catalog.id_currency = catalog_currencies.id
    //     AND catalog.id_availability IS NOT NULL

    //     GROUP BY catalog.id) SELECT *
    //     FROM current_price 
    //     WHERE current_price.id_category = 10
        
        
    //     GROUP BY price_in_uah ASC

}




