<?php

require_once "carlistFactory.php";

class carlistGet extends carlistFactory{

    function __construct(){
       $uri = $_SERVER["REQUEST_URI"];
       $uriArray = explode('/', $uri);
       $year = $uriArray[2];
       $manufacturer = $uriArray[3];
       $model = $uriArray[4];
       
       $this->initCarFactory($year,$manufacturer,$model);

       
       return true;
       
    }
}

