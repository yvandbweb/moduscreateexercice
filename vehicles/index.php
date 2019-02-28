<?php

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':  
        require_once "carlistPost.php";
        new carlistPost();      
        break;
    case 'GET':
        require_once "carlistGet.php";
        new carlistGet();             
        break;
}




