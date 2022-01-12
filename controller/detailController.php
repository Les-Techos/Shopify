<?php require_once "controller.php";
require_once "./models/Customer.php";
require_once "./models/Customer.php";

/**
 * Controller for the product details view
 */
class detailController extends controller
{

    public function __construct()
    {
        $this->controllerData["detailProduit"] = "";
        $this->controllerData["formComment"]  = "";
        $this->controllerData["reviews"] = "";
        $this->controllerData['note']=0;

    }


    public function routerDefaultAction()
    {
        $this->throwAdmin();
        if (!empty($_POST['product_to_add'])) {
            if (!empty($_POST['post']))
                $this->sendComment();
            $this->returnCards($_POST['product_to_add']);
            $this->commentAllowed();
            return ($this->controllerData);
        } else {
            header('Location: ./');
            exit();
        }
    }

    /**
     * @param mixed $Product_id
     * Send to the view the html code to display the product
     * @return void
     */
    public function returnCards($Product_id)
    {
        $Product = null;

        try{
            $Product = new Product($Product_id);
            $Product->order_66();
        }catch(Exception $e){
            throw $e;
        }



        foreach ($Product->linked_datas->reviews as $Review) {
            $this->controllerData['note'] += $Review->datas->stars;
            $this->controllerData["reviews"] .=

                '<div class="card mb-3" style="max-width: 480px;">
                        <div class="row g-0">

                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">' . $Review->datas->name_user . ' : '. $Review->datas->stars.'/5</h5> 
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
        $this->controllerData['note'] = number_format((float) ($this->controllerData['note']/count($Product->linked_datas->reviews)), 1, ",", " ");

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

    /**
     * Send a comment
     */
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

    /**
     * @param String $str
     * This removes special char from a string
     * @return string
     */
    public function RemoveSpecialChar($str)
    {
        $res = preg_replace('/[0-9\@\.\;\" "]+/', ' ', $str);
        return $res;
    }

    /**
     * if the user is connected, this allow him to send a review under a product thanks to the display of a form in the view, else it just ask the user to connect
     */
    public function commentAllowed()
    {
        if (!empty($_SESSION['connection_id'])) {
            $this->controllerData["formComment"] = '<div class="card-footer">
                <form method="post" action="">
                    <div class="form-outline w-100">
                        <input type="hidden" id="product_to_add" name="product_to_add" value="'.$_POST["product_to_add"].'" />
                        <input type="text" name="title" class="form-control" id="textAreaExample" rows="2" style="background: #fff;" placeholder="Titre" required />
                        <input type="text" name="comment" class="form-control" id="textAreaExample" rows="2" style="background: #fff;" placeholder="Commentaire" required />
                        

                    </div>

                    <div class="float-end mt-2 pt-1">   
                        <h6 style="margin-left:15%">Note :
                        <input type="number" value="5" name="note" min="1" max="5" style="width:10%; margin-left:0%;"/>
                        <input type="submit" name="post" class="btn btn-primary btn-sm" value="Poster Commentaire" style="margin:auto"/>
                        <input type="reset" class="btn btn-outline-primary btn-sm" value="Annuler" style="margin-right:15%"/></h6>

                    </div>
                </form>';
        } else {
            $this->controllerData["formComment"] = '<a href="./?action=signIn" class="btn btn-primary" id="Mobile_Btn">
                                                        Se connecter pour poster un avis
                                                    </a>';
        }
    }
}
