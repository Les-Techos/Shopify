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
        include_once("../models/Login.php");
        $c = new Customer(2);
        

        ///START METASTASIS

        ///END METASTASIS
        $b = Customer::get_new_fresh_obj();
        print($b);
        $b->datas->forname = "Jean-Mouloud";
        $b->datas->registered = "1";
        $l = Login::get_new_fresh_obj();
        $l->datas->customer_id = $b->id;
        $b->linked_datas->logins[0] = $l;
        $b->set_data();

        foreach($c->linked_datas->orders as $order){
            //print(strval($order));
        }
       
        $c->set_data();
    ?>
</body>

</html>