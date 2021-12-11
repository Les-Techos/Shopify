<?php
abstract class DB_data
{
  public $id = '0';
  public $data_table = ' ';
  public $id_name = ' ';

  public function __construct($id_p, $data_table_p, $id_name_p)
  {
    $this->id = $id_p;
    $this->data_table = $data_table_p;
    $this->id_name = $id_name_p;
  }

  public function set_data()
  {
  }

  public function get_data()
  {
    $res = getDatasLike($this->data_table, [$this->id_name, $this->id]);
    if ($res != null) {
      $res = $res[0];
      foreach ($res as $key => $val) {
        if (property_exists($this, $key)) {
          $this->{$key} = $val;
        }
      }
    }
  }
}