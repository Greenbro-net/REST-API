<?php

namespace App\Core;

use App\Core\View;
use Exception;

class Controller
{
    protected $view;
    protected $model;


    public function view($viewName, $data =[])
    {
        try {
                $this->view = new View($viewName, $data);
                if (empty($this->view)) {
                    throw new Exception("Method view has had empty value");
                } else {
                    return $this->view;
                       }

            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
    }

    public function model( string $modelName, $data=[])
    {
        try {
            if(class_exists("\\App\Model\\" . $modelName))
            {
                $modelName = "\\App\Model\\" . $modelName;
                $this->model = new $modelName;
                
            } else {
                throw new Exception("Method model hasn't found current model class");
                   }

            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }


    public function load_model_obj(string $modelName, $data=[])
    {
        try {
            if (class_exists("\\App\Model\\" . $modelName)) {
                $modelName = "\\App\Model\\" . $modelName;

                return $this->model = new $modelName;

               } else {
                throw new Exception("Method load_model_obj hasn't found current model class");
                      }

            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                  'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }

     
}