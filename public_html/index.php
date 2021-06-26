<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

use App\Core\Application;
use App\Controller\TroubleController;

// the function below checkout does methods and controllers exist or not
function checkout_url()
{ 
    $url = Application::clearupParameter();

    // folder where we store our classes 
    $file_controller_names = array_slice(scandir('App/Controller/'), 2);

    // the code below gets controller name and store it in array  
    foreach($file_controller_names as $controller_key => $file_controller_name ) {
    // the code below deletes empty arrays from array 
        
        // the code below for gets name with Controller part 
        $file_controller_array = explode('.', $file_controller_name);
        // the arrays below have names of controllers  
        $controller_names[$controller_key] = $file_controller_array[0];


        // the code below for gets name without Controller part 
        $file_controller_array = explode('Controller', $file_controller_name);
        $short_controller_names[$controller_key] = $file_controller_array[0];
    }

    // the function below gets methods name and create array with class methods
    foreach($controller_names as $controller_name) {

        $arrays_method_names[] = get_class_methods("App\Controller\\".$controller_name);
    }
    // the function below  makes one simple array and delete three methods 
    foreach($arrays_method_names as $method_names) {
        
            foreach($method_names as $key_method_name => $method_name) {
                
                if (($method_name == 'view') || ($method_name == 'model') || ($method_name == '__construct')) {
                    unset($method_names[$key_method_name]);
                } else {
                    $controller_methods[] = $method_name; 
                       }   
                } 
            }


    // the code below for case of pure domain name greenbro.net
    if (empty($url[0]) && empty($url[1])) {
      Application::call_by_url();
      return $variable = TRUE;
    }
    // the code below for case only one of two url parameters
    elseif(empty($url[0]) || empty($url[1])) {
     $variable = FALSE;
    }

    elseif (!empty($url[0]) && !empty($url[1])) {
      foreach ($short_controller_names as $controller_name_check) {

        if ((strcasecmp($controller_name_check, $url[0]) == 0)) {

            foreach ($controller_methods as $controller_method_check)
            {
               if ($controller_method_check == $url[1]) {
                //    the code below calls method of actual controller 
                   Application::call_by_url();
                   return $variable = TRUE;
               } 
            }
        }  else { // the else block escapes undefined variable notice beloц
            $variable = FALSE;
                }
            } 
        }
    // if page does not exists you will be located in 404.php
    if ($variable !== TRUE) {
        $page_404 = new TroubleController();
        $page_404->page_404();
    }

}





// Application is call in checkout_url function above
checkout_url();
?>



