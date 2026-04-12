<?php

require_once __DIR__."/../models/service.class.php";

class ServiceController {

    public static function findService($id){

    
    }
   public static function getAllService(){
        try{
            $arr_service = Service::allService();

            header('Content-Type: application/json');

            echo json_encode($arr_service);

        } catch(Exception $ex){
            http_response_code(500);

            echo json_encode([
                "error" => $ex->getMessage()
            ]);
        }
    }
}