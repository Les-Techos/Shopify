<?php

include_once('bd.php');

abstract class DB_Object
{
  public $id = '0';
  public $data_table = ' ';
  public $id_name = ' ';
  public DB_datas $datas, $oldDatas;

  public function __construct($id_p, $data_table_p, $id_name_p)
  {
    $this->id = $id_p;
    $this->data_table = $data_table_p;
    $this->id_name = $id_name_p;
  }

  public function set_data()
  {
    foreach(get_object_vars($this->datas) as $property => $val){
      $oldProperty = &$this->oldDatas->{$property};
      $newProperty = $val;
      if($newProperty != $oldProperty) updateDatas($this->data_table, [$this->id_name, $this->id, $this->id] ,[$property, $oldProperty, $newProperty]);
    }
  }



  public function get_data()
  {
    if (getDatasLike($this->data_table, $res, [$this->id_name, $this->id])) {
      $res = $res[0];
      foreach ($res as $key => $val) {
        if (property_exists($this->datas, $key)) {
          $this->datas->{$key} = $val;
        }
      }
    }
    $this->oldDatas = clone $this->datas;
  }
}

abstract class DB_datas{

}

?>