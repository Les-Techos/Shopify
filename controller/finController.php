<?php
require_once "controller.php";


/**
 * Controller for the end of command view
 */
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
