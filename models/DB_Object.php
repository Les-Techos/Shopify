<?php

include_once('bd.php');

/**
 * @abstract
 * Base template for every table in DB.
 */
abstract class DB_Object
{
  public $id = '0'; // Id
  public static $data_table = ' '; // Table name
  public $id_name = 'id'; // Name of column "id"
  public DB_datas $datas, $oldDatas; // datas related to the Table (modified and last get from DB)

  /**
   * Constructor
   *
   * @param int $id_p
   * @param string $data_table_p
   * @param string $id_name_p
   */
  public function __construct(int $id_p = -1)
  {
    $this->id = $id_p;

    $attributes = getColumnName($this::$data_table, 3); //Get the table columns name
    $this->datas = new DB_datas; //Create a fresh new implementation of DB_data receiving the DB
    foreach ($attributes as $name => $val) { //Insert each column as an attribute in datas
      $this->datas->{$val} = "";
    }

    if ($id_p != -1)
      $this->get_data(); //Once datas set up, retrieve DB's datas
  }


  /**
   * Update the DB with the modifications made to datas attributes
   *
   * @return void
   */
  public function set_data()
  {
    foreach (get_object_vars($this->datas) as $property => $val) { //For each attributes of datas, we verified if they are modified compare to the DB content

      $oldProperty = &$this->oldDatas->{$property};
      $newProperty = &$val;
      if ($newProperty != $oldProperty) updateDatas($this::$data_table, [$this->id_name, $this->id, $this->id], [$property, $oldProperty, $newProperty]); //In that case, we update the corresponding property in the DB.
    }
  }


  /**
   * Retrieve datas from DB
   *
   * @return void
   */
  public function get_data()
  {
    if (getDatasLike($this::$data_table, $res, [$this->id_name, $this->id])) { // Get the tuple with the id of da instancied object and pursue if a result is returned
      $res = $res[0]; //Extract the first element (Only one element corresponds to the id above).
      foreach ($res as $key => $val) { //Set the attributes with corresponding DB datas
        if (property_exists($this->datas, $key)) { //Check if da property really exists
          $this->datas->{$key} = $val; //Set the value
        }
      }
    }
    $this->oldDatas = clone $this->datas; //Keep a trace of the DB current state
  }

  public static function get_data_array(&$OBJ_Array, $id_name, $id)
  {
    if (getDatasLike(self::$data_table, $res, [$id_name, $id])) { // Get the tuple with the id of da instancied object and pursue if a result is returned
      $i = 0;
      foreach ($res as $tuple) {
        $OBJ_Array[] = new static();
        $curr_obj = &$OBJ_Array[$i];
        foreach ($tuple as $key => $val) { //Set the attributes with corresponding DB datas
          if (property_exists($curr_obj->datas, $key)) { //Check if da property really exists
            $curr_obj->datas->{$key} = $val; //Set the value
          }
        }
        $curr_obj->oldDatas = clone  $curr_obj->datas; //Keep a trace of the DB current state
        $curr_obj->id = $curr_obj->datas->{"id"};
        $i++;
      }
    }
  }

  public function metastasis(...$VALUES)
  {
    $attributes = getColumnName($this::$data_table, 3); //Get the table columns name
    $this->datas = new DB_datas; //Create a fresh new implementation of DB_data receiving the DB 
    foreach ($attributes as $name => $val) { //Insert each column as an attribute in datas
      $this->datas->{$val} = "";
    }
  }

  /**
   * To String
   *
   * @return string
   */
  public function __toString()
  {
    $res = "";
    $res = print_r($this->datas, true);
    return $res;
  }
}

/**
 * @abstract
 * Design to receive the DB datas
 */
class DB_datas
{
}

class DB_linked_datas
{
}
