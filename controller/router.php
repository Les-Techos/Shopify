<?php

require_once "adminController.php";
require_once "detailController.php";
require_once "panierController.php";
require_once "produitController.php";
require_once "renseignementController.php";
require_once "sign-inController.php";
require_once "userController.php";           

class router{

    public function guideRequest() {
        try{
            
            if(isset( $_GET['action']) && !empty( $_GET['action'])){
                $action = $_GET['action'];
                if(file_exists( $_SERVER['DOCUMENT_ROOT']."/view/".$action.".php")){
                include($action."Controller.php");
                $contents = $action.".php";}
                else{
                    throw new Exception("action invalide");
                }
                require_once("./view/template.php");
            }else{
                $contents = "produit.php";
                require_once("./view/template.php");
            }



        }catch(Exception $e){
            throw new Exception("Erreur !: " . $e->getMessage() . "<br/>");
        }
    }

}
