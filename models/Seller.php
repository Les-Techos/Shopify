<?php

include_once("User.php");

class seller extends User{
    public function __construct($id_p){
        parent::__construct($id_p,'admin', 'id');
    }
}

?>