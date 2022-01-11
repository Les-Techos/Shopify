<div class="container-fluid" id="centre">
    <div class="row">
        <?= $controllerData["detailProduit"] ?>
        <div class="col-sm">
            <div class="card" style="max-height: 600px; width: 500px;">
                <h5 class="card-header"> Commentaire et note </h5>
                <div class="card-body" id="CommentCardBody">


                    <?= $controllerData["reviews"] ?>


                </div>
                <div class="card-footer">
                    <form method="post" action="">
                        <div class="form-outline w-100">
                            <input type="hidden" id="product_to_add" name="product_to_add" value="<?=$_POST["product_to_add"]?>" />
                            <input type="text" name="title" class="form-control" id="textAreaExample" rows="2" style="background: #fff;" placeholder="Titre" required />
                            <input type="text" name="comment" class="form-control" id="textAreaExample" rows="2" style="background: #fff;" placeholder="Commentaire" required />
                            <input type="number" value="3" name="note" min_value="1" max_value="5" width="10px" />

                        </div>

                        <div class="float-end mt-2 pt-1">


                            <input type="submit" name="post" class="btn btn-primary btn-sm" value="Poster Commentaire" />
                            <input type="reset" class="btn btn-outline-primary btn-sm" value="Annuler" />

                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>