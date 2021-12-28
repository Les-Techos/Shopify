<?php

class router{

    public function guideRequest() {
        try{
            
            if(isset( $_GET['action']) && !empty( $_GET['action'])){
                $action = $_GET['action'];
                if(file_exists( $_SERVER['DOCUMENT_ROOT']."/view/".$action.".php"))
                $contents = $action.".php";
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
?>