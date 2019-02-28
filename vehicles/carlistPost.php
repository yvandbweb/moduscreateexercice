<?php

require_once "carlistFactory.php";

class carlistPost extends carlistFactory{

    function __construct(){
        
       $year = $_POST["modelYear"];
       $manufacturer = $_POST["manufacturer"];
       $model = $_POST["model"];        
       
       $this->initCarFactory($year,$manufacturer,$model);      
       
    }   
}
