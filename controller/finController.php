<?php
require_once "controller.php";


class finController extends controller
{



    public function routerDefaultAction()
    {
        $this->throwAdmin();
        if(empty($_GET["file"])){
            header('Location: ./');
            exit();
        }
    }


    
}
