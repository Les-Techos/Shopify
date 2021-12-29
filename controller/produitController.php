<?php

require_once './models/Product.php';

class produitController
{

    public $p;
    public $controllerData;

    public function __construct()
    {
        Product::get_data_array($this->p, "id", '%_');
        $this->controllerData  = "";
    }

    public function home()
    {
        if (!(isset($_POST['rangeInput']) && isset($_POST['inputGroupSelect01']))) {
            foreach ($this->p as $aProduct) {
                $this->controllerData  .= '<div class="col-md-12 col-lg-4">
            <div class="card card border-primary mb-3">
                <div class="card-header">' .
                    $aProduct->datas->name
                    . '</div>
                <img src="..\assets\image\\' . $aProduct->datas->image . '">
                <div class="card-body">
                    <p class="text-center">' . $aProduct->datas->description . '</p>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="btn btn-primary"> Achat direct</a>
                    <a href="#" class="btn btn-primary"> Ajouter au panier</a>
                </div>
            </div>
        </div>';
            }
        } else {
            if (empty($_POST["floatingInput"])) {
                $textToSearch  = " ";
            } else {
                $textToSearch = $_POST["floatingInput"];
            }
            
            foreach ($this->p as $aProduct) {

                if ((strpos($aProduct->datas->description, $textToSearch) !== false) && ($aProduct->datas->price <= intval($_POST['rangeInput']))) {
                    $this->controllerData  .= '<div class="col-md-12 col-lg-4">
                            <div class="card card border-primary mb-3">
                                <div class="card-header">' .
                                        $aProduct->datas->name
                                        . '</div>
                                <img src="..\assets\image\\' . $aProduct->datas->image . '">
                                <div class="card-body">
                                    <p class="text-center">' . $aProduct->datas->description . '</p>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#" class="btn btn-primary"> Achat direct</a>
                                    <a href="#" class="btn btn-primary"> Ajouter au panier</a>
                                </div>
                            </div>
                        </div>';
                }
            }
        }
    }
}
