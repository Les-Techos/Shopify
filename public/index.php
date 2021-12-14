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
    Coucou
    <?php
        include_once("../models/Customer.php");
        include_once("../models/Seller.php");
        include_once("../models/Order.php");
        $c = new Customer();
        $c->id = 2; $c->get_data();
       // print(strval($c) . "<br>");

        $a = new Seller(1);
        //print(strval($a) . "\n");

        $o = new Order(63);
        //print(strval($o) . "\n");

        $res = array();
        Order::get_data_array($res, "customer_id", "2");
        foreach($res as $tuple){
            print_r(strval($tuple));
            print("<br><br><br><br><br>");
        }
        
    ?>
</body>

</html>