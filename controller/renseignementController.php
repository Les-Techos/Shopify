<?php require_once "controller.php";
require_once "./models/Address.php";
require_once('./assets/fpdf/fpdf.php');

/**
 * Controller for the validation page
 */
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
                
                header('Location: ./?action=fin&file='.session_id().$this->objDatabase["order"]->datas->id);
                exit();
            }

            return $this->controllerData;
        } else {
            header('Location: ./');
            exit();
        }
    }

    /**
     * if the user is connected, this method automatically fill the form
     */
    public function getCustomerInfo()
    {
        if (!empty($_SESSION["connection_id"])) {
            $this->objDatabase["customer"] = new Customer($_SESSION["connection_id"]);
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
            $this->objDatabase["customer"] = Customer::get_new_fresh_obj();
        }
    }

    /**
     * Send to the view the cart infos which are the number if products and the quantity
     */
    public function getCartInfos()
    {
        foreach ($_SESSION['PANIER'] as $ProductData) {
            $Product  = new Product($ProductData["product_id"]);
            $this->controllerData["nbArticles"] += $ProductData["quantity"];
            $this->controllerData["Total"] +=  $ProductData["quantity"] * $Product->datas->price;
        }
    }
    /**
     * Select the order in the database in which you will store the order
     */
    public function selectOrder()
    {
        if (!empty($_SESSION["connection_id"]) && empty($_SESSION["OrderNumber"]) && ($_SESSION["status"] == "user")) {
            $arrayUnachievedOrders = [];
            Order::get_data_array($arrayUnachievedOrders, "customer_id", $_SESSION["connection_id"]);
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
                    $this->objDatabase["order"] = new Order($ord->id);
                }
            }
        } elseif (empty($_SESSION["connection_id"]) && empty($_SESSION["OrderNumber"])) {
            $this->getNeworder();
        }
    }

    /**
     * Creates a new order for the database
     */
    public function getNeworder()
    {
        $this->objDatabase["order"] = Order::get_new_fresh_obj();
        $this->objDatabase["order"]->datas->delivery_add_id = "NULL";
        $this->objDatabase["order"]->datas->payment_type = "NULL";
        $this->objDatabase["order"]->datas->date = "'" . date('Y-m-d', time()) . "'";
        $this->objDatabase["order"]->datas->status = 0;
        $this->objDatabase["order"]->datas->session = "'" . session_id() . "'";
        $this->objDatabase["order"]->datas->total = "NULL";
        $this->objDatabase["order"]->datas->customer_id = "NULL";
        $this->objDatabase["order"]->datas->registered = 1;
    }

    /**
     * Create a new delivery address for every command
     */
    public function getNewDeliveryAdd()
    {
        $this->objDatabase["Add"] = Address::get_new_fresh_obj();
        $this->objDatabase["Add"]->datas->firstname = "NULL";
        $this->objDatabase["Add"]->datas->lastname = "NULL";
        $this->objDatabase["Add"]->datas->add1 = "NULL";
        $this->objDatabase["Add"]->datas->add2 = "NULL";
        $this->objDatabase["Add"]->datas->city = "NULL";
        $this->objDatabase["Add"]->datas->postcode = "NULL";
        $this->objDatabase["Add"]->datas->phone = "NULL";
        $this->objDatabase["Add"]->datas->email = "NULL";
    }

        /**
     * Remove all the products items of the order in database to simplify the upload process
     */
    public function cleanDatabase()
    {
        $orderitems = [];
        Order_item::get_data_array($orderitems, "order_id", $this->objDatabase["order"]->datas->id);
        if (!empty($orderitems)) {
            foreach ($orderitems as $order_item) {
                $order_item->apoptose();
            }
        }
    }

    /**
     * Set the delivery address with form datas
     */
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
        $this->objDatabase["Add"]->set_data();
    }

    /**
     * Set the customer infos with form datas
     */
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
        $this->objDatabase["customer"]->set_data();
    }

    /**
     * Set the order infos with form datas
     */
    public function setOrder()
    {
        $this->objDatabase["order"]->datas->delivery_add_id = $this->objDatabase["Add"]->datas->id;
        $this->objDatabase["order"]->datas->payment_type = "'" . $_POST["paymentMethod"] . "'";
        $this->objDatabase["order"]->datas->date = "'" . date('Y-m-d', time()) . "'";
        if ($_POST["paymentMethod"] == "paypal") {
            $this->objDatabase["order"]->datas->status = 3;
        } else {
            $this->objDatabase["order"]->datas->status = 1;
        }
        $this->objDatabase["order"]->datas->session = "'" . session_id() . "'";
        $this->objDatabase["order"]->datas->total = $this->controllerData["Total"];
        $this->objDatabase["order"]->datas->customer_id = $this->objDatabase["customer"]->datas->id;
        $this->objDatabase["order"]->datas->registered = 1;
        $this->objDatabase["order"]->set_data();
    }

    /**
     * Store order in the database
     */
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
                $Cart_products = Order_item::get_new_fresh_obj();
                $Cart_products->datas->order_id = $this->objDatabase["order"]->datas->id;
                $Cart_products->datas->product_id = $Product['product_id'];
                $Cart_products->datas->quantity = $Product['quantity'];
                $Cart_products->set_data();
            }
        }
        unset($_SESSION["PANIER"]);
    }
    
    /**
     * generate a PDF bill with all the infos collected in the form
     */
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
        $pdf->Cell(47, 5, utf8_decode($this->objDatabase["order"]->datas->date), 0, 1); //end of line

        $pdf->Cell(94, 5, '', 0, 0);
        $pdf->Cell(47, 5, utf8_decode('Numéro de commande'), 0, 0);
        $pdf->Cell(47, 5, utf8_decode($this->objDatabase["order"]->datas->id), 0, 1); //end of line

        $pdf->Cell(94, 5, '', 0, 0);
        $pdf->Cell(47, 5, utf8_decode("Numéro de client"), 0, 0);
        $pdf->Cell(47, 5, utf8_decode($this->objDatabase["order"]->datas->customer_id), 0, 1); //end of line

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(189, 10, '', 0, 1); //end of line

        $pdf->SetFont('Arial', 'B', 14);
        //billing address
        $pdf->Cell(90, 5, 'Adresse de Livraison', 0, 0); //end of line
        $pdf->Cell(90, 5, 'Adresse de Facturation', 0, 1); //end of line
        //add dummy cell at beginning of each line for indentation

        $pdf->SetFont('Arial', '', 14);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["prenomL"].' '.$_POST["nomL"]) , 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["prenom"].' '.$_POST["nom"]) , 0, 1);
        
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["add1L"]), 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["add1"]), 0, 1);


        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["add2L"]), 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["add2"]), 0, 1);


        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["add3L"]), 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["add3"]), 0, 1);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["codepostalL"]) , 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["codepostal"]) , 0, 1);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["mailL"]), 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["mail"]), 0, 1);

        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["telL"]), 0, 0);
        $pdf->Cell(10, 5, '', 0, 0);
        $pdf->Cell(90, 5, utf8_decode($_POST["tel"]), 0, 1);

        $pdf->Cell(189, 10, '', 0, 1); //end of line

        $pdf->SetFont('Arial', 'B', 14);

        $pdf->Cell(90, 5, "Paiement choisi : ", 0, 0);
        $pdf->Cell(90, 5, $_POST["paymentMethod"], 0, 1);


        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(189, 10, '', 0, 1); //end of line


        $pdf->Cell(130, 5, 'Nom du Produit', 1, 0);
        $pdf->Cell(25, 5, utf8_decode('Quantité'), 1, 0);
        $pdf->Cell(34, 5, 'Prix', 1, 1); //end of line

        $pdf->SetFont('Arial', '', 12);

        //Numbers are right-aligned so we give 'R' after new line parameter
        $amount = 0;
        //display the items
        foreach ($_SESSION["PANIER"] as $item) {
            $orderItem = new Product($item['product_id']);
            $pdf->Cell(130, 5, utf8_decode($orderItem->datas->name), 1, 0);
            //add thousand separator using number_format function
            $pdf->Cell(25, 5, number_format($item['quantity']), 1, 0);
            $montant = $orderItem->datas->price * $item['quantity'];
            $pdf->Cell(34, 5, number_format($montant), 1, 1, 'R'); //end of line
            //accumulate tax and amount
            $amount += $montant;
        }

        //summary


        $pdf->Cell(130, 5, '', 0, 0);
        define('EURO',chr(128));
        $pdf->Cell(25, 5, 'Total :', 1, 0);        
        $pdf->Cell(30, 5, number_format($amount), 1, 0, 'R'); //end of line
        $pdf->Cell(4, 5, EURO, 1, 1);
        $name = "./assets/bills/".session_id().$this->objDatabase["order"]->datas->id.".pdf";
        $pdf->Output('F',  $name);


    }

    
}
