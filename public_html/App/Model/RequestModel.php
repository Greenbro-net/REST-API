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
        if (empty($query)) {
            throw new Exception("Method grab_catalog_data hasn't got argument");
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

    public function grab_total_rows_quantity(string $query)
    { 
        try {
        if (empty($query)) {
            throw new Exception("Method grab_total_rows_quantity hasn't got parameter");
        }

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

    public function grab_total_filtered_rows_quantity(string $query)
    { 
        try {
        if (empty($query)) {
            throw new Exception("Method grab_total_filtered_rows_quantity hasn't got parameter");
        }

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




