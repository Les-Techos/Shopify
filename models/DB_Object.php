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
  public static $id_name = 'id'; // Name of column "id"
  
  public $datas = null, $oldDatas = null; // datas related to the Table (modified and last get from DB)
  
  public $linked_datas = null;
  public $linked_datas_info = null;
  public $linked_column_infos = null;

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

    $attributes = getColumnName($this::$data_table); //Get the table columns name
    $this->datas = (new class extends DB_datas{}); //Create a fresh new implementation of DB_data receiving the DB
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
    if ($this->oldDatas != null) { //If id exists then we have to update
      foreach (get_object_vars($this->datas) as $property => $val) { //For each attributes of datas, we verified if they are modified compare to the DB content

        $oldProperty = &$this->oldDatas->{$property};
        $newProperty = &$val;
        if ($newProperty != $oldProperty) updateDatas($this::$data_table, [static::$id_name, $this->id, $this->id], [$property, $oldProperty, $newProperty]); //In that case, we update the corresponding property in the DB.
      }
    } else { // Id it doesn't we have to create it
      $param_to_insert = array();
      foreach (get_object_vars($this->datas) as $property => $val) { //Build all query's settings
        $param_to_insert[] = ["$property", "$val"];
      }
      addData(static::$data_table, $param_to_insert); //Add imself's datas to DB
      $this->oldDatas = clone $this->datas; //Keep a trace of the DB current state
    }
    if ($this->linked_datas != null) { //Do the same for linked datas
      foreach (get_object_vars($this->linked_datas) as $property => $elem) { //We spread the behavior to linked datas
        foreach ($elem as $key => $val) {
          $val->set_data();
        }
      }
    }
  }

  /**
   * Retrieve datas from DB
   *
   * @return void
   */
  public function get_data()
  {
    if (getDatasLike($this::$data_table, $res, [static::$id_name, $this->id])) { // Get the tuple with the id of da instantiated object and pursue if a result is returned
      $res = $res[0]; //Extract the first element (Only one element corresponds to the id above).
      foreach ($res as $key => $val) { //Set the attributes with corresponding DB datas
        if (property_exists($this->datas, $key)) { //Check if da property really exists
          $this->datas->{$key} = $val; //Set the value
        }
      }
    }
    $this->oldDatas = clone $this->datas; //Keep a trace of the DB current state
  }

  /**
   * Looks for linked datas in DB according to linked_datas_info and linked_column_info
   * Put them in linked_datas with same name given in linked_datas_info/linked_column_info
   *
   * @return void
   */
  public function order_66()
  {
    //print("<br>");
    $reflector = new ReflectionClass($this->linked_datas_infos); //Get properties from linked datas
    $this->linked_datas = (new class extends DB_linked_datas
    {
    }); //Create an instance of the future res attributes

    foreach ($reflector->getProperties() as $property) { //For each property of customer
      $type = $property->getType()->getName(); //Get class name of da property
      $attribut_name = $property->getName(); //Get the attribute name of $property
      $refl = new ReflectionClass($type); //Create a reflection class associated to the property

      //print("1 attribut de type : ($type) $attribut_name  <br>");

      getDatasLike(($type)::$data_table, $buff, [$this->linked_column_infos->{$attribut_name}, $this->id]); //Get name of data_table ($type)::$data_table where "customer_id" = $c->id

      $nb_elem = count($buff); // Get the number of element from sql result
      //print("Taille du tableau " . $nb_elem . "<br>");        

      $this->linked_datas->{$attribut_name} = array();

      //print("Creation d'un tableau à la place de l'attribut <br> <br>");
      foreach ($buff as $tuple) {
        //print("Le tableau : "); print_r($tuple);
        $o = $refl->newInstanceArgs([$tuple[static::$id_name]]);  //Create an instance of da property
        //print("Nouvel élément de l'attribut : " . strval($o) . " <br> <br>");
        $this->linked_datas->{$attribut_name}[] = $o;
      }
    }
  }

  /**
   * Destroy the object itself and its linked_datas in DB beginning by those lasts
   *
   * @return void
   */
  public function apoptose()
  {
    if ($this->linked_datas != null) {
      foreach (get_object_vars($this->linked_datas) as $property => $val) { //For each attributes of datas, we verified if they are modified compare to the DB content
        foreach ($this->linked_datas->{$property} as $elem) {
          $elem->apoptose();
        }
      }
    }
    deleteDatas(static::$data_table, [static::$id_name, $this->id]);
  }

  /**
   * Get all obj instantiated
   *
   * @param [type] $OBJ_Array
   * @param [type] $id_name
   * @param [type] $id
   * @return void
   */
  public static function get_data_array(&$OBJ_Array, $id_name, $id)
  {
    if (getDatasLike(static::$data_table, $res, [$id_name, $id])) { // Get the tuple with the id of da instantiated object and pursue if a result is returned
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

  public static function get_new_fresh_obj()
  {
    $new_obj = new static();
    $new_obj->id = getMaxIdIn(static::$data_table, static::$id_name) + 1;
    $new_obj->datas->id = $new_obj->id;
    return $new_obj;
  }

  /**
   * To String
   *
   * @return string
   */
  public function __toString()
  {
    $res = get_class($this) . "<br>";
    foreach (get_object_vars($this->datas) as $property => $elem) { //For each attributes of datas, we verified if they are modified compare to the DB content and so modified them
        $res .= "[$property] : $elem <br>";
    }
    if ($this->linked_datas != null) { //Do the same for linked datas
      foreach (get_object_vars($this->linked_datas) as $property => $elem) { //For each attributes of datas, we verified if they are modified compare to the DB content and so modified them
        $res .= "<br>";
        foreach ($elem as $key => $val) {
          $res .= $val->__toString();
        }
      }
    }
    $res .= "<br>";
    return $res;
  }
}

/**
 * @abstract
 * Design to receive the DB datas
 */
abstract class DB_datas
{
}

abstract class DB_linked_datas_infos
{
}

abstract class DB_linked_column_infos
{
}

abstract class DB_linked_datas
{
}
