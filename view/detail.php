<div class="container-fluid" id="centre">
    <div class="row">
        <?= $controllerData["detailProduit"] ?>
        <div class="col-sm">
            <div class="card" style="max-height: 600px; width: 500px; ">
                <h5 class="card-header"> Commentaires :  </h5>
                <h6 class="card-header"> Note : <?=$controllerData['note'] ?>/5 </h6>
                <div class="card-body" id="CommentCardBody" style="overflow-y:scroll; max-height:500px">


                    <?= $controllerData["reviews"] ?>


                </div>
                <?= $controllerData["formComment"]?>
                </div>
            </div>

        </div>

    </div>
</div>