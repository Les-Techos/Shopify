<?php require_once "controller.php";
require_once "./models/Customer.php";
require_once "./models/Customer.php";

class detailController extends controller
{

    public function __construct()
    {
        $this->controllerData["detailProduit"] = "";
    }


    public function routerDefaultAction()
    {
        $this->throwAdmin();
        if (!empty($_POST['product_to_add'])) {
            if (!empty($_POST['post']))
                $this->sendComment();
            $this->returnCards($_POST['product_to_add']);
            return ($this->controllerData);
        } else {
            header('Location: ./');
            exit();
        }
    }

    public function returnCards($Product_id)
    {
        $Product = new Product($Product_id);
        $Product->order_66();

        $this->controllerData["reviews"] = "";

        foreach ($Product->linked_datas->reviews as $Review) {

            $this->controllerData["reviews"] .=

                '<div class="card mb-3" style="max-width: 480px;">
                        <div class="row g-0">

                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $Review->datas->name_user . '</h5>
                                    <p class="card-text">' .
                $Review->datas->title
                . '</p>
                                    <p class="card-text">' .
                $Review->datas->description
                . '</p>

                                </div>
                            </div>
                        </div>
                    </div>';
        }

        $this->controllerData["detailProduit"] .= '
        <div class="col-sm">
            <img src="./assets\image\\' . $Product->datas->image . '" style="max-width:100%;">
        </div>
        <div class="col-sm">
            <div class="card">
                <h5 class="card-header">' . $Product->datas->name . '</h5>
                <div class="card-body">
                    <h5 class="card-title">' . $Product->datas->price . ' €</h5>
                    <p class="card-text">' . $Product->datas->description . '</p>
                    
                        <form method="post" action=".\?action=panier">
                            Quantité
                            <input type="number" value="1"  name="quantity" style="min-width:25px; max-width:50px" min="1" />
                            <input type="hidden" id ="idProduct" name="idProduct" value="' . $Product->datas->id . '"/>
                            <button type="submit" class="btn btn-success" >Ajouter au Panier</a>
                        </form>
                    
                </div>
            </div>
        </div>
       ';
    }

    public function sendComment()
    {
        $customer = new Customer($_SESSION['connection_id']);
        $review = Review::get_new_fresh_obj();
        $review->datas->id_product = "'" . $_POST['product_to_add'] . "'";
        $review->datas->name_user = "'" . $customer->datas->forname . "'";
        $review->datas->photo_user = "'" . "homme.jpg" . "'";
        $review->datas->stars = "'" . $_POST["note"] . "'";
        $review->datas->title = "'" . $this->RemoveSpecialChar($_POST["title"]) . "'";
        $review->datas->description = "'" . $this->RemoveSpecialChar($_POST["comment"]) . "'";
        $review->set_data();
    }

    public function RemoveSpecialChar($str)
    {
        $res = preg_replace('/[0-9\@\.\;\" "]+/', ' ', $str);
        return $res;
    }
}
