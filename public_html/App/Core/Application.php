<?php

namespace App\Core;

use Exception;


class Application
{
    static protected $controller;
    static protected $action; // a method name
    static protected $prams = [];


    static public function call_by_url()
    {
        try {
                self::prepareCALL();
                if(class_exists("\\App\Controller\\" . self::$controller) ) {
                    self::$controller = "\\App\Controller\\" . self::$controller;

                    self::$controller = new self::$controller;
                    if(method_exists(self::$controller, self::$action)) {
                        call_user_func_array([self::$controller, self::$action], self::$prams);
                    }
                } else {
                    throw new Exception("Method call_by_url hasn't found current controller");
                       }

            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }

    // the  method below  prepares url for call  
    static protected function prepareCALL()
    {
            $url = self::clearupParameter();
            // the code below sets controller name for calling
            self::$controller = isset($url[0]) ? $url[0].'Controller' : 'HomeController';
            // the code below sets method name for calling
            self::$action = isset($url[1]) ? $url[1] : 'index';
            unset($url[0], $url[1]);
            self::$prams = !empty($url) ? array_values($url) : [];
    }


    // the method below allows adding parameter after controller/method
    static public function clearupParameter()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        if(!empty($request)) {
             $url = explode('/', $request);
             // the code below checks are not empty values     
            if (!empty($url[0]) && !empty($url[1])) {
               if (strpos($url[1], '?')) {
                $position = strpos($url[1], '?');
                $url[1] = substr($url[1], 0, $position); 
                    }
                }    

              return $url;   
            }
           
    }


}
