<?php require_once "controller.php";

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
            $this->returnCards($_POST['product_to_add']);
            return ($this->controllerData);
        } else {
            header('Location: /');
            exit();
        }
    }

    public function returnCards($Product_id)
    {
        $Product = new Product($Product_id);
        $this->controllerData["detailProduit"] .= '
        <div class="col-sm">
            <img src="../assets\image\\' . $Product->datas->image . '" style="max-width:100%;">
        </div>
        <div class="col-sm">
            <div class="card">
                <h5 class="card-header">' . $Product->datas->name . '</h5>
                <div class="card-body">
                    <h5 class="card-title">' . $Product->datas->price . ' €</h5>
                    <p class="card-text">' . $Product->datas->description . '</p>
                    <div class="button-group">
                        <form method="post" action="\?action=panier">
                            Quantité
                            <input type="number" value="1"  name="quantity" style="min-width:25px; max-width:50px" min="1" />
                            <input type="hidden" id ="idProduct" name="idProduct" value="' . $Product->datas->id . '"/>
                            <button type="submit" class="btn btn-success" >Ajouter au Panier</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       ';
    }
}
