<?php
include_once("User.php");
class seller extends User{
    public function __construct($id_p){
        self::$data_table = 'admin';
        parent::__construct($id_p);
    }
}
?>