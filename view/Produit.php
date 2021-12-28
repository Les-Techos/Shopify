<div class="row">
    <p style="text-align:center">
        <strongbutton class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#Searchmenu" aria-expanded="false" aria-controls="collapseExample">
            Filtres
            </button>
    </p>
    <div class="collapse" id="Searchmenu">
        <div class="card card-body">
            <form class="form-horizontal">
                <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 ">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Thé au Jasmin">
                        <label for="floatingInput">Que cherchez vous ?</label>
                    </div>
                    <div class="col-mb3">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Type de produit</label>
                            <select class="form-select" id="inputGroupSelect01">
                                <option selected>Choisir...</option>
                                <option value="1">Thé et Café</option>
                                <option value="2">Biscuit</option>
                                <option value="3">Fruit sec</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-mb3">
                        Prix maximum désiré:
                        <input id="rangeInput" type="range" class="form-range" min="0" max="50" oninput="amount.value=rangeInput.value" />
                    </div>
                        <div class="col-sm1">
                        <input id="amount" type="number" value="25" min="0" max="200" oninput="rangeInput.value=amount.value" disabled />€
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-outline-primary">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Disposition pour le test des card surement un chaangement des card ultériurement si nécessaire-->
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
    <?= $controllerData ?>
</div>
<!-- faire le controlleur pour donner le nombre de page-->
<div class="pagination justify-content-center">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
</div>