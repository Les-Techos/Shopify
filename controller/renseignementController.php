<?php require_once "controller.php";

class renseignementController extends controller{

    public function routerDefaultAction(){
        $this->throwAdmin();
    }
}

?>