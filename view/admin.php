<div class="container-fluid">
    <div class="col-lg">
        <div class="card" style="max-height:600px">
            <div class="card-header">Commandes à expédier <a href="#" class="card-link" style="text-align:right">Déconnexion</a></div>
            <div class="card-body">
                <ul style="overflow-y:scroll; max-height:500px">
                    <?php for ($i = 1; $i <= 15; $i++) {
                        echo '<li class = "list-group-item">
                           Achat du client n°213163831
                           <button type="button" class="btn btn-success" >Valider achat &#x2705; </button>
                           <button type="button" class="btn btn-primary" >Détails achat &#9997; </button>
                       </li>';
                    }
                    ?>
            </div>
        </div>
    </div>
</div>