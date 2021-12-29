<div class="container-fluid">
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
                <li>
                    <a href="/?action=user" class="btn btn-primary">
                        Mon compte
                    </a>
                </li>
                <li>
                    <button class="btn btn-primary" type="button">
                        Demande
                    </button>
                </li>
                <li>

                    <strongbutton class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#Panier" aria-expanded="false" aria-controls="collapseExample">
                        Panier
                        </button>
                </li>
            </ul>
    </nav>
    <div class="containers">
        <div class="collapse" id="Panier">
            <ul class="list-group">
                <?php for ($i = 1; $i <= 3; $i++) {
                    echo '<li class="list-group-item">
                                        <input type="checkbox" value="" id="product A">
                                        <img src="..\assets\image\assortimentBiscuitsSec.jpg">
                                        Product name
                                        <input type="number" style="min-width:25px; max-width:50px"/>
                                        </li>';
                } ?>
            </ul>
        </div>
    </div>
</div>