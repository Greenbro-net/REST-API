<?php

namespace App\Model;

use App\Controller\RequestController;
use PDO;


class RequestModel 
{
    private static $host   = DATABASE_HOST;
    private static $dbName = DATABASE_NAME;
    private static $username = DATABASE_USERNAME;
    private static $password = DATABASE_PASSWORD;

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

    // the function below gets customer_id from the same customer name from customers table 
    protected function selectCustomerId($query, $params)
    { 
        try {
        $sql_statement = self::connect()->prepare($query);

        // this block of code for updating quantity of paremeters which we should post in execute
        $sql_statement->bindParam(1, $params[0]["param_value"], PDO::PARAM_STR);

        if (!empty($params[1]["param_value"])) {
            $sql_statement->bindParam(2, $params[1]["param_value"], PDO::PARAM_STR);
        }
        
        if (!empty($params[2]["param_value"])) {
            $sql_statement->bindParam(3, $params[2]["param_value"], PDO::PARAM_STR);
        }

        if (!empty($params[3]["param_value"])) {
            $sql_statement->bindParam(4, $params[3]["param_value"], PDO::PARAM_STR);
        }


        $result_selectCustomerId = $sql_statement->execute();

        $result_customer_id = $sql_statement->fetchAll();
    

        if (empty($result_customer_id)) {
                throw new PDOException("Function selectCustomerId wasn't successful!");
                                        } else {
                                           return $result_customer_id; 
                                               }
        } catch (PDOException $exception) {
            file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
              'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                          }
    }

    public  function grab_catalog_data(RequestController $request_controller_obj)
    { 
        try {
    
    // the statement with WITH instead of 
    // $query = "WITH current_price AS (
    //     SELECT catalog.id, catalog.name, id_brand, id_availability, price, id_currency, SUM(catalog_currencies.rate * catalog.price) 
    //     AS price_in_uah from catalog,catalog_currencies 
    //     WHERE catalog.id_currency = catalog_currencies.id GROUP BY catalog.id)
    //     SELECT * FROM current_price 
    //     GROUP BY price_in_uah";


    $query = "WITH current_price AS ( 
        SELECT catalog.id, catalog.name, id_brand,catalog.id_category, id_availability, price, id_currency, 
        COUNT(*) over () as total_count,
        SUM(catalog_currencies.rate * catalog.price) AS price_in_uah from catalog,catalog_currencies 
        WHERE catalog.id_currency = catalog_currencies.id GROUP BY catalog.id) SELECT *, 
        COUNT(*) over () as actual_count FROM current_price 
        WHERE current_price.id_category = $request_controller_obj->id_category GROUP BY price_in_uah";

    
    

    $stmt = $this->connect()->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
             if (empty($results)) {
                 throw new Exception("Method grab_data_catalog returns empty results");
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
        $query = "SELECT COUNT(*) as totalNumberOfFilteredItems FROM catalog WHERE id_category = $request_controller_obj->id_category";
    

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

    

    
}




