<?php 

require_once "controller.php";
require_once './models/Product.php';
require_once './models/Category.php';

/**
 * Controller for the website's main page
 */
class produitController extends Controller
{
    public function __construct()
    {
        
        $this->controllerData  = "";
    }

    public function routerDefaultAction()
    {
        try{Product::get_data_array($this->objDatabase, "id", '%_');}catch(Exception $e){throw $e;}
        $this->throwAdmin();
        if (!(isset($_POST['rangeInput']) && isset($_POST['inputGroupSelect01']))) {
            foreach ($this->objDatabase as $aProduct) {
                $this->returnProductCard($aProduct);
            }
        } else {
            if (empty($_POST["floatingInput"])) {
                $textToSearch  = " ";
            } else {
                $textToSearch = $_POST["floatingInput"];
            }
            $catreceived =  filter_input(INPUT_POST, "inputGroupSelect01", FILTER_SANITIZE_STRING);

            foreach ($this->objDatabase as $aProduct) {

                if ($catreceived == "all") {
                    if (((strpos($aProduct->datas->description, $textToSearch) !== false)  || (strpos($aProduct->datas->name, $textToSearch) !== false))   && ($aProduct->datas->price <= intval($_POST['rangeInput']))) {
                        $this->returnProductCard($aProduct);
                    }
                } else {
                    try{$catProduct = new Category($aProduct->datas->cat_id);}catch(Exception $e){throw $e;}

                    if (((strpos($aProduct->datas->description, $textToSearch) !== false)  || (strpos($aProduct->datas->name, $textToSearch) !== false)) && ($aProduct->datas->price <= intval($_POST['rangeInput'])) && ($catreceived == $catProduct->datas->name)) {
                        $this->returnProductCard($aProduct);
                    }
                }
            }
        }
        return $this->controllerData;
    }

    /**
     * @param Product $aProduct
     * Send to the view the html code to display the product in parameter
     */
    public function returnProductCard($aProduct){
        $this->controllerData  .= ' <div class="col-md-12 col-lg-4" id = "'.$aProduct->datas->id.'">
                                <div class="card card border-primary mb-3" id="CardProduit">
                                <div class="card-header" id="CardHeader"> <h3>'.
                            $aProduct->datas->name
                            . '</h1></div>
                                <img src=".\assets\image\\' . $aProduct->datas->image . '">
                                <div class="card-body">
                                    <p class="text-center">' . $aProduct->datas->description . '</p>
                                </div>
                                <div class="card-footer text-center">
                                    <form action="./?action=detail" method="post" class="form-example">
                                        <input type="hidden" id ="product_to_add" name="product_to_add" value="'.$aProduct->datas->id.'"/>
                                        <button type="submit" class="btn btn-primary"> Voir les détails</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        ';
    }
}
