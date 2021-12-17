<?php
include_once("User.php");
class seller extends User{
    public static $data_table = 'admin';
    public function __construct($id_p = -1){
        parent::__construct($id_p);
    }
}
?>