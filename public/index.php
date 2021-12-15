<!Doctype HTML>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <title>Shop Rtf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        include_once("../models/Customer.php");
        include_once("../models/Seller.php");
        include_once("../models/Order.php");
        $c = new Customer(2);

        ///START METASTASIS
        /*
            Changement : $c -> $this
                "custumer_id" -> 
        */

        $reflector = new ReflectionClass($c->linked_datas_infos); //Get properties from linked datas
        $c->linked_datas = (new class extends DB_linked_datas{}); //Create an instance of the future res attributes

        foreach($reflector->getProperties() as $property) { //For each property of customer
            $type = $property->getType()->getName(); //Get class name of da property
            $attribut_name = $property->getName(); //Get the attribute name of $property
            $refl = new ReflectionClass($type); //Create a reflection class associated to the property

            print("1 attribut de type : ($type) $attribut_name  <br>");

            getDatasLike(($type)::$data_table, $buff, ["customer_id", $c->id]); //Get name of data_table ($type)::$data_table where "customer_id" = $c->id
            
            $nb_elem = count($buff); // Get the number of element from sql result
            print("Taille du tableau " . $nb_elem . "<br>");        
            
            $c->linked_datas->{$attribut_name} = array();

            print("Creation d'un tableau à la place de l'attribut <br> <br>");
            foreach($buff as $tuple){
                print("Le tableau : "); print_r($tuple);
                $o = $refl->newInstanceArgs([$tuple["id"]]);  //Create an instance of da property
                print("Nouvel élément de l'attribut : " . strval($o) . " <br> <br>");
                $c->linked_datas->{$attribut_name}[] = $o;
            }     
        }

        ///END METASTASIS

        print_r('$c->linked_datas->{'.$attribut_name.'} <br>');
        print_r($c->linked_datas->{$attribut_name});
       

    ?>
</body>

</html>