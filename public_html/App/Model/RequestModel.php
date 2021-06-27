<?php

namespace App\Model;

use PDO;


class RequestModel {
    private static $host   = DATABASE_HOST;
    private static $dbName = DATABASE_NAME;
    private static $username = DATABASE_USERNAME;
    private static $password = DATABASE_PASSWORD;
    // the property below for load_model method 
    protected $model;

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

    public  function grab_data_catalog()
    { 
        try {
    // will check does we have the same customer data(last name, mobile number, email) in catalog table
    $query = "SELECT * FROM catalog WHERE catalog.id_category = 8 AND (catalog.price) BETWEEN 500 AND 100000
            ORDER BY catalog.price DESC";

    $query = "SELECT catalog.name, id_currency, short_name, price 
    FROM catalog, catalog_currencies
    WHERE id_currency != 4 AND catalog.id_currency = catalog_currencies.id
    ";

    $query = "select SUM(catalog_currencies.rate * catalog.price) 
    AS price_in_uah from catalog,catalog_currencies
    WHERE catalog.id = 5 AND catalog_currencies.id = 6  

    ";

    $query = "select SUM(catalog_currencies.rate * catalog.price) 
    AS price_in_uah from catalog,catalog_currencies
    WHERE catalog.id_currency = catalog_currencies.id
    GROUP BY catalog.id";

    // the statement below is right query which order items in right order by price
    $query = "SELECT * FROM (select catalog.name, price, id_currency, SUM(catalog_currencies.rate * catalog.price) 
    AS price_in_uah from catalog,catalog_currencies 
    WHERE catalog.id_currency = catalog_currencies.id GROUP BY catalog.id) sub GROUP BY price_in_uah";

    // the statement with WITH instead of 
    $query = "WITH current_price AS (
        SELECT catalog.name, price, id_currency, SUM(catalog_currencies.rate * catalog.price) 
        AS price_in_uah from catalog,catalog_currencies 
        WHERE catalog.id_currency = catalog_currencies.id GROUP BY catalog.id)
        SELECT * FROM current_price 
        GROUP BY price_in_uah";

    // example with WHEN statements 
    $query = "WITH current_price AS (
        SELECT catalog.name, price, id_currency, SUM(catalog_currencies.rate * catalog.price) 
        AS price_in_uah from catalog,catalog_currencies WHERE catalog.id_currency = catalog_currencies.id GROUP BY catalog.id)
    
    SELECT price_in_uah, CASE
        WHEN price_in_uah >= 500000 THEN 'Expensive'
        WHEN price_in_uah >= 200000 THEN 'Medium'
        WHEN price_in_uah >= 50000 THEN 'Cheap'
        ELSE 'Feather'
        END AS how_expensive
    FROM current_price 
    GROUP BY price_in_uah";

    $stmt = $this->connect()->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
             if (empty($results)) {
                 throw new Exception("grab_data_catalog returns empty results");
                                  }
            } catch (Exception $exception) {
                    file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                      'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    public function show_entries()
    {
        var_dump($this->grab_data_catalog());
    }

    
}

$request_model_object = new RequestModel();


echo "<pre>";
var_dump($request_model_object->grab_data_catalog());


