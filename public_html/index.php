<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

use App\Core\Application;
use App\Controller\TroubleController;

// the function below checkout does methods and controller exist or not
function checkout_url()
{ 
    $url = Application::clearupParameter();

            $controller_name = !empty($url[0]) ? ucfirst($url[0]) . "Controller" : false;

                if (empty($url[0]) && empty($url[1])) {
                    Application::call_by_url();
                     $variable = TRUE;
                 }
                elseif (class_exists("\\App\Controller\\" . $controller_name) ) {
                    $controller = "\\App\Controller\\" . $controller_name;

                    $controller = new $controller;
                    if(method_exists($controller, $url[1])) {
                        Application::call_by_url();
                        $variable = TRUE;
                    } 
                } else {
                    $variable = FALSE;
                       }

                // if page does not exists you will be located in 404.php
                if(empty($variable)) {
                    $page_404 = new TroubleController();
                    $page_404->page_404();
                }
    
}





// Application is call in checkout_url function above
checkout_url();

if (!empty($_GET['error_message'])) {
    echo $_GET['error_message'];
}
?>



