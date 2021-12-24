<!Doctype HTML>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <title>Shop Rtf</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="..\public\style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <?php
        include_once("../view/Header.php");
        ?>
    <div class="container-fluid">        
      <div class="row"> 
            <div class="span4">
            <?php include_once("../view/admin.php");?>
            </div> 
        </div>
    </div>
           
        </div>
        <?php
        include_once("../view/Footer.php");
        /*
        include_once("../models/Customer.php");
        include_once("../models/Seller.php");
        include_once("../models/Order.php");
        include_once("../models/Login.php");
        
        
        for($i = 3; $i < 8; $i++){
            $b = new Customer($i);
            $b->apoptose();
        }
       

        
        $b = Customer::get_new_fresh_obj(); //Créer un tout nouveau objet avec un nouvel id

        $d = &$b->datas; //On se réfère à ses données dans la DB
        $d->forname = "Jean-Mouloud";
        $d->registered = "1";
        $d->surname = "Hector";
        $d->add1="Rue de la Pierre";
        $d->phone ="0687180914";
        
        $l = Login::get_new_fresh_obj(); //On crée un nouveau login
        $d_l = &$l->datas; //" "
        $d_l->customer_id = $b->id;
        $d_l->username = "Ouèch trop bien";

        $b->linked_datas->logins[0] = $l; //On dit à l'utilisateur qu'il a un login
        
        $o = Order::get_new_fresh_obj();
        
        $o_d = &$o->datas;
        $o_d->customer_id = $b->id;
        $o_d->registered = "1"; 
        $o_d->delivery_add_id = "49";
        $o_d->date = "2020-01-23";
        $o_d->status = "10";
        $o_d->total = "90";
        $o_d->payment_type = "cheque";

        $b->linked_datas->orders[0] = $o;
        
        $b->set_data(); // On sauvegarde les données

        print($b);
         */
    ?>
</body>

</html>