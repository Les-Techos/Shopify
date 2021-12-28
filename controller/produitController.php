<?php

require_once './models/Product.php';
$p;
Product::get_data_array($p, "id", '%_');
$controllerData  = "";
foreach ($p as $aProduct){
    $controllerData  .= '<div class="col-md-4">
        <div class="card card border-primary mb-3">
            <div class="card-header">'.
               $aProduct->datas->name
            .'</div>
            <img src="..\assets\image\\'.$aProduct->datas->image.'">
            <div class="card-body">
                <p class="text-center">'.$aProduct->datas->description.'</p>
            </div>
            <div class="card-footer text-center">
                <a href="#" class="btn btn-primary"> Achat direct</a>
                <a href="#" class="btn btn-primary"> Ajouter au panier</a>
            </div>
        </div>
    </div>'; 
 } 
?>