<?php

class modus{
    
    const url1="https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/year1/make/manufacturer1/model/model1?format=json";
    const urlVehiculeRated="https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/vehicleid1?format=json";
    
    function __construct(){
        
    }
    
    private function getJsonContent($url){
       return json_decode(file_get_contents($url),TRUE);
    }
    
    private function getJsonOutput($json,$withrating){       
       $results=array();
       if ($json==null)
           $results["Count"]=0;
       else
           $results["Count"]=$json["Count"];
       
       if ($json["Count"]==0){
            $results["Results"]=array();
       }else{                        
            $i=0;
            $results["Results"]=array();
            foreach ($json["Results"] as $res){
                 if ($withrating==true){
                     $rating=$this->getJsonContent(str_replace("vehicleid1",$res["VehicleId"],self::urlVehiculeRated));  
                     $results["Results"][$i]["CrashRating"]=$rating["Results"][0]["OverallRating"];                    
                 }                
                 $results["Results"][$i]["Description"]=$res["VehicleDescription"];
                 $results["Results"][$i]["VehicleId"]=$res["VehicleId"];                 

                 $i++;
            }
       }
        
       $json=json_encode($results, JSON_PRETTY_PRINT);
       print('<pre>'.print_r($json, true).'</pre>');
       return $json;
    }    
    
    
    public function requirementOne($withrating){
       $uri = $_SERVER["REQUEST_URI"];
       $uriArray = explode('/', $uri);
       $year = $uriArray[2];
       $manufacturer = $uriArray[3];
       $model = $uriArray[4];        
       $url=str_replace("year1",$year,self::url1);
       $url=str_replace("manufacturer1",$manufacturer,$url);
       $url=str_replace("model1",$model,$url);
       $json=$this->getJsonContent($url);       
       $this->getJsonOutput($json,$withrating);
       
       return true;
       
    }
    
    public function requirementTwo($withrating){
       $url=str_replace("year1",$_POST["modelYear"],self::url1);      
       $url=str_replace("manufacturer1",$_POST["manufacturer"],$url);     
       $url=str_replace("model1",$_POST["model"],$url);       
       $json=$this->getJsonContent($url);       
       $this->getJsonOutput($json,$withrating);
       
       return true;
       
    }    
}


$modus=new Modus();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($_GET["withRating"]=="true")
            $modus->requirementTwo(true);
        else
            $modus->requirementTwo(false);        
        break;
    case 'GET':
        if ($_GET["withRating"]=="true")  
            $modus->requirementOne(true);
        else
            $modus->requirementOne(false);               
        break;
}




