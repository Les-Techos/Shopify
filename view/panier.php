<!--Fichier de test du panier-->
<div class="row g-5">
    <ul class="list-group col-md-7 col-lg-8">
        <?= $controllerData["list"] ?>
    </ul>
    <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Panier</span>
            <span class="badge bg-primary rounded-pill">Nombres d'article : <?= $controllerData["nbArticles"] ?></span>
        </h4>
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between">
                <span>Total (Euro)</span>
                <strong><?= $controllerData["Total"] . " €" ?></strong>
            </li>
        </ul>
        <?=$controllerData["ValidateButton"]?>
    </div>
</div>
<br />