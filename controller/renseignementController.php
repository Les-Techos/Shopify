<?php require_once "controller.php";
require_once "./models/Address.php";
require_once('./assets/fpdf/fpdf.php');

class renseignementController extends controller
{

    public function __construct()
    {
        $this->controllerData["nbArticles"] = 0;
        $this->controllerData["prenom"] = "";
        $this->controllerData["nom"] = "";
        $this->controllerData["mail"] = "";
        $this->controllerData["add1"] = "";
        $this->controllerData["add2"] = "";
        $this->controllerData["add3"] = "";
        $this->controllerData["codepostal"] = "";
        $this->controllerData["tel"] = "";
        $this->controllerData["Total"] = 0;
        $this->controllerData["prenomL"] = "";
        $this->controllerData["nomL"] = "";
        $this->controllerData["mailL"] = "";
        $this->controllerData["add1L"] = "";
        $this->controllerData["add2L"] = "";
        $this->controllerData["add3L"] = "";
        $this->controllerData["codepostalL"] = "";
        $this->controllerData["telL"] = "";
    }

    public function routerDefaultAction()
    {
        $this->throwAdmin();
        if (!empty($_SESSION["PANIER"])) {
            $this->getCustomerInfo();
            $this->getCartInfos();
            if (!empty($_POST["pay"])) {
                $this->selectOrder(); 
                $this->generateBill();               
                $this->setOrderInCloud();
                
                header('Location: /?action=fin');
                exit();
            }

            return $this->controllerData;
        } else {
            header('Location: /');
            exit();
        }
    }

    public function getCustomerInfo()
    {
        if (!empty($_SESSION["connection_id"])) {
            try{$this->objDatabase["customer"] = new Customer($_SESSION["connection_id"]);}catch(Exception $e){throw $e;}
            $customer = &$this->objDatabase["customer"];
            $this->controllerData["nom"]  = $customer->datas->surname;
            $this->controllerData["prenom"] = $customer->datas->forname;
            $this->controllerData["add1"] = $customer->datas->add1;
            $this->controllerData["add2"] = $customer->datas->add2;
            $this->controllerData["add3"] = $customer->datas->add3;
            $this->controllerData["codepostal"] = $customer->datas->postcode;
            $this->controllerData["mail"]  = $customer->datas->email;
            $this->controllerData["tel"] = $customer->datas->phone;
            $this->controllerData["prenomL"] =  $customer->datas->forname;
            $this->controllerData["nomL"] = $customer->datas->surname;
            $this->controllerData["mailL"] = $customer->datas->email;
            $this->controllerData["add1L"] = $customer->datas->add1;
            $this->controllerData["add2L"] = $customer->datas->add2;
            $this->controllerData["add3L"] = $customer->datas->add3;
            $this->controllerData["codepostalL"] = $customer->datas->postcode;
            $this->controllerData["telL"] = $customer->datas->phone;
        } else {
            try{$this->objDatabase["customer"] = Customer::get_new_fresh_obj();}catch(Exception $e){throw $e;}
        }
    }

    public function getCartInfos()
    {
        foreach ($_SESSION['PANIER'] as $ProductData) {
            $Product  = null;
            try{$Product = new Product($ProductData["product_id"]);}catch(Exception $e){throw $e;}
            $this->controllerData["nbArticles"] += $ProductData["quantity"];
            $this->controllerData["Total"] +=  $ProductData["quantity"] * $Product->datas->price;
        }
    }

    public function selectOrder()
    {
        if (!empty($_SESSION["connection_id"]) && empty($_SESSION["OrderNumber"]) && ($_SESSION["status"] == "user")) {
            $arrayUnachievedOrders = [];
            try{Order::get_data_array($arrayUnachievedOrders, "customer_id", $_SESSION["connection_id"]);}catch(Exception $e){throw $e;}
            if (!empty($arrayUnachievedOrders)) {
                $offset = 0;
                foreach ($arrayUnachievedOrders as $Order) {
                    if (($Order->datas->status > 0) || ($Order->datas->customer_id != $_SESSION["connection_id"])) {
                        unset($arrayUnachievedOrders[$offset]);
                    }
                    $offset++;
                }
            }
            if (empty($arrayUnachievedOrders)) {
                $this->getNeworder();
            } else {
                foreach ($arrayUnachievedOrders as $ord) {
                    try{$this->objDatabase["order"] = new Order($ord->id);}catch(Exception $e){throw $e;};
                }
            }
        } elseif (empty($_SESSION["connection_id"]) && empty($_SESSION["OrderNumber"])) {
            $this->getNeworder();
        }
    }

    public function getNeworder()
    {
        try{$this->objDatabase["order"] = Order::get_new_fresh_obj();}catch(Exception $e){throw $e;}
        $this->objDatabase["order"]->datas->delivery_add_id = "NULL";
        $this->objDatabase["order"]->datas->payment_type = "NULL";
        $this->objDatabase["order"]->datas->date = "'" . date('Y-m-d', time()) . "'";
        $this->objDatabase["order"]->datas->status = 0;
        $this->objDatabase["order"]->datas->session = "'" . session_id() . "'";
        $this->objDatabase["order"]->datas->total = "NULL";
        $this->objDatabase["order"]->datas->customer_id = "NULL";
        $this->objDatabase["order"]->datas->registered = 1;
    }

    public function getNewDeliveryAdd()
    {
        try{$this->objDatabase["Add"] = Address::get_new_fresh_obj();}catch(Exception $e){throw $e;}
        $this->objDatabase["Add"]->datas->firstname = "NULL";
        $this->objDatabase["Add"]->datas->lastname = "NULL";
        $this->objDatabase["Add"]->datas->add1 = "NULL";
        $this->objDatabase["Add"]->datas->add2 = "NULL";
        $this->objDatabase["Add"]->datas->city = "NULL";
        $this->objDatabase["Add"]->datas->postcode = "NULL";
        $this->objDatabase["Add"]->datas->phone = "NULL";
        $this->objDatabase["Add"]->datas->email = "NULL";
    }

    public function cleanDatabase()
    {
        $orderitems = [];
        try{Order_item::get_data_array($orderitems, "order_id", $this->objDatabase["order"]->datas->id);}catch(Exception $e){throw $e;};
        if (!empty($orderitems)) {
            foreach ($orderitems as $order_item) {
                try{$order_item->apoptose();}catch(Exception $e){throw $e;}
            }
        }
    }

    public function setDeliveryAdd()
    {
        $this->objDatabase["Add"]->datas->firstname = "'" . $_POST["prenomL"] . "'";
        $this->objDatabase["Add"]->datas->lastname = "'" . $_POST["nomL"] . "'";
        $this->objDatabase["Add"]->datas->add1 = "'" . $_POST["add1L"] . "'";
        $this->objDatabase["Add"]->datas->add2 = "'" . $_POST["add2L"] . "'";
        $this->objDatabase["Add"]->datas->city = "'" . $_POST["add3L"] . "'";
        $this->objDatabase["Add"]->datas->postcode = "'" . $_POST["codepostalL"] . "'";
        $this->objDatabase["Add"]->datas->phone = "'" . $_POST["telL"] . "'";
        $this->objDatabase["Add"]->datas->email = "'" . $_POST["mailL"] . "'";
        try{$this->objDatabase["Add"]->set_data();}catch(Exception $e){throw $e;}
    }
    public function setCustomer()
    {
        $this->objDatabase["customer"]->datas->forname = "'" . $_POST["prenom"] . "'";
        $this->objDatabase["customer"]->datas->surname = "'" . $_POST["nom"] . "'";
        $this->objDatabase["customer"]->datas->add1 = "'" . $_POST["add1"] . "'";
        $this->objDatabase["customer"]->datas->add2 = "'" . $_POST["add2"] . "'";
        $this->objDatabase["customer"]->datas->add3 = "'" . $_POST["add3"] . "'";
        $this->objDatabase["customer"]->datas->postcode = "'" . $_POST["codepostal"] . "'";
        $this->objDatabase["customer"]->datas->phone = "'" . $_POST["tel"] . "'";
        $this->objDatabase["customer"]->datas->email = "'" . $_POST["mail"] . "'";
        $this->objDatabase["customer"]->datas->registered = 1;
        try{$this->objDatabase["customer"]->set_data();}catch(Exception $e){throw $e;}
    }

    public function setOrder()
    {
        $this->objDatabase["order"]->datas->delivery_add_id = $this->objDatabase["Add"]->datas->id;
        $this->objDatabase["order"]->datas->payment_type = "'" . $_POST["paymentMethod"] . "'";
        $this->objDatabase["order"]->datas->date = "'" . date('Y-m-d', time()) . "'";
        if ($_POST["paymentMethod"] == "paypal") {
            $this->objDatabase["order"]->datas->status = 3;
        } else {
            $this->objDatabase["order"]->datas->status = 2;
        }
        $this->objDatabase["order"]->datas->session = "'" . session_id() . "'";
        $this->objDatabase["order"]->datas->total = $this->controllerData["Total"];
        $this->objDatabase["order"]->datas->customer_id = $this->objDatabase["customer"]->datas->id;
        $this->objDatabase["order"]->datas->registered = 1;
        try{$this->objDatabase["order"]->set_data();}catch(Exception $e){throw $e;}
    }

    public function setOrderInCloud()
    {
        if (empty($_POST["mail"]))
            $_POST["mail"] = "NULL";
        if (empty($_POST["mailL"]))
            $_POST["mailL"] = "NULL";
        if (empty($_POST["add2"]))
            $_POST["add2"] = "NULL";
        if (empty($_POST["add2L"]))
            $_POST["add2L"] = "NULL";
        $this->selectOrder();
        $this->getNewDeliveryAdd();
        $this->setDeliveryAdd();
        $this->getCustomerInfo();
        $this->setCustomer();

        $this->setOrder();


        $this->cleanDatabase();
        if (!empty($_SESSION['PANIER'])) {
            foreach ($_SESSION['PANIER'] as $Product) {
                $Cart_products = null;
                try{$Cart_products = Order_item::get_new_fresh_obj();}catch(Exception $e){throw $e;}
                $Cart_products->datas->order_id = $this->objDatabase["order"]->datas->id;
                $Cart_products->datas->product_id = $Product['product_id'];
                $Cart_products->datas->quantity = $Product['quantity'];
                try{$Cart_products->set_data();}catch(Exception $e){throw $e;}
            }
        }
        unset($_SESSION["PANIER"]);
    }
    
    public function generateBill()
    {
        $pdf = new FPDF('P', 'mm', 'A4');

        $pdf->AddPage();

        //set font to arial, bold, 14pt
        $pdf->SetFont('Arial', 'B', 14);

        //Cell(width , height , text , border , end line , [align] )

        $pdf->Cell(94, 5, 'WEB4SHOP', 0, 0);
        $pdf->Cell(94, 5, utf8_decode('Récapitulatif de commande'), 0, 1); //end of line

        //set font to arial, regular, 12pt
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(94, 5, '', 0, 0);
        $pdf->Cell(94, 5, '', 0, 1); //end of line

        $pdf->Cell(94, 5, '', 0, 0);
        $pdf->Cell(47, 5, 'Date', 0, 0);
        $pdf->Cell(47, 5, 'date', 0, 1); //end of line

        $pdf->Cell(94, 5, '', 0, 0);
        $pdf->Cell(47, 5, utf8_decode('Numéro de commande'), 0, 0);
        $pdf->Cell(47, 5, 'invoiceID', 0, 1); //end of line

        $pdf->Cell(94, 5, '', 0, 0);
        $pdf->Cell(47, 5, utf8_decode("Numéro de client"), 0, 0);
        $pdf->Cell(47, 5, 'clientID', 0, 1); //end of line

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(189, 10, '', 0, 1); //end of line

        //billing address
        $pdf->Cell(100, 5, 'Destinataire de la facture', 0, 1); //end of line

        //add dummy cell at beginning of each line for indentation
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, 'name', 0, 1);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, 'company', 0, 1);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, "adresse", 0, 1);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, "phone", 0, 1);

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(189, 10, '', 0, 1); //end of line

        //invoice contents
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(130, 5, 'Nom du Produit', 1, 0);
        $pdf->Cell(25, 5, utf8_decode('Quantité'), 1, 0);
        $pdf->Cell(34, 5, 'Prix', 1, 1); //end of line

        $pdf->SetFont('Arial', '', 12);

        //Numbers are right-aligned so we give 'R' after new line parameter
        $amount = 0;
        //display the items
        foreach ($_SESSION["PANIER"] as $item) {
            $pdf->Cell(130, 5, $item['product_id'], 1, 0);
            //add thousand separator using number_format function
            $pdf->Cell(25, 5, number_format($item['quantity']), 1, 0);
            $pdf->Cell(34, 5, "montant", 1, 1, 'R'); //end of line
            //accumulate tax and amount
            //$amount += $item['amount'];
        }

        //summary


        $pdf->Cell(130, 5, '', 0, 0);
        $pdf->Cell(25, 5, 'Total Due', 0, 0);
        $pdf->Cell(4, 5, '€', 1, 0);
        $pdf->Cell(30, 5, number_format($amount), 1, 1, 'R'); //end of line
        $name = "./assets/bills/".session_id().".pdf";
        $pdf->Output('F',  $name);


    }

    
}
