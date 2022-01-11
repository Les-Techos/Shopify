<div class="container-fluid" id="begin">
    <div class="row">
        <img src=".\assets\image\Web4ShopHeader.png" id="Headerimg" alt="logo">
    </div>
</div>
<div class="container-fluid">
    <nav class="navbar navbar-expand-md navbar-light">
        <a href="./" class="navbar-brand">
            <img src=".\assets\image\Web4ShopHeader.png" id="Navbarimg" alt="logo">
            Web4SHOP</a>
        <div class="collapse" id="collapseMobileMenu">
            <ul class="navbar-nav">
                <li>
                    <a href="./" class="btn btn-primary" id="Mobile_Btn">
                        Produit
                    </a>
                
                <?= $ConnectionButton ?>
                </li>
            </ul>
        </div>
        <button type="button" class="navbar-toggler" data-bs_toggle="collapse" data-bs-target="#toggleMenu" aria-controls="toggleMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" data-toggle="collapse" href="#collapseMobileMenu" role="button" aria-expanded="false" aria-controls="collapseMobileMenu">
            </span>
        </button>
        
        <div class="navbar-collapse collapse" id="toggleMenu">
            <ul class="navbar-nav">
                <li>
                    <a href="./" class="btn btn-primary" id="Mobile_Btn">
                        Produit
                    </a>
                </li>
                <?= $ConnectionButton ?>

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