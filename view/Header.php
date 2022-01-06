<div class="container-fluid" id="begin">
    <div class="row">
        <img src="..\assets\image\Web4ShopHeader.png" alt="logo" width="100%" height="250">
    </div>
</div>
<div class="container-fluid">
    <nav class="navbar navbar-expand-md navbar-light">
        <a href="/" class="navbar-brand">
            <img src="..\assets\image\Web4ShopHeader.png" alt="logo" width="30" height="24">
            Web4SHOP</a>
        <button type="button" class="navbar-toggler" data-bs_toggle="collapse" data-bs-target="#toggleMobileMenu" aria-controls="toggleMobileMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">Toggle navigation</span>
        </button>
        <div class="navbar-collapse collapse" id="toggleMobileMenu">
            <ul class="navbar-nav">
                <li>
                    <a href="/" class="btn btn-primary">
                        Produit
                    </a>
                </li>
                <?= $ConnectionButton?>
               
            </ul>
    </nav>
    <div class="containers">
        <div class="collapse" id="Panier">
            <ul class="list-group">
                <?= $HeaderPanier; ?>
            </ul>
            <!--<a href="/?action=panier" class="btn btn-success"> Vérifier mon panier</a>-->
        </div>
    </div>
</div>