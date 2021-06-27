<?php

namespace App\Model;

class TroubleModel 
{
    public function show404()
    {
        include VIEW . "trouble/" . "index" . '.phtml';
    }
}