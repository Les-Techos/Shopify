
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <div class="container">
    <main>
      <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Panier</span>
            <span class="badge bg-primary rounded-pill">Nombres d'article : <?=$controllerData["nbArticles"]?></span>
          </h4>
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (Euro)</span>
              <strong><?=$controllerData["Total"]." €"?></strong>
            </li>
          </ul>
        </div>
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation"  action="">
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Un prénom valide est requis
                </div>
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Nom de famille</label>
                <input type="text" class="form-control" id="lastName" placeholder="" value="" required>
                <div class="invalid-feedback">
                  Un nom valide est requis
                </div>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                <input type="email" class="form-control" id="email" placeholder="you@example.com">
                <div class="invalid-feedback">
                  Entrez un email valide.
                </div>
              </div>

              <div class="col-12">
                <label for="add1" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                <div class="invalid-feedback">
                  Entrez une adresse d'expédition valide
                </div>
              </div>

              <div class="col-12">
                <label for="add2" class="form-label">Complément d'adresse <span class="text-muted">(Optional)</span></label>
                <input type="text" class="form-control" id="address2" placeholder="Etage, code immeuble...">
              </div>

              <div class="col-12">
                <label for="add3" class="form-label">Ville</label>
                <input type="text" class="form-control" id="address" placeholder="New York" required>
                <div class="invalid-feedback">
                  Entrez une ville valide
                </div>
              </div>     

              <div class="col-md-3">
                <label for="postalcode" class="form-label">Code Postal</label>
                <input type="text" class="form-control" id="zip" placeholder="" required>
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>


            <hr class="my-4">

            <h4 class="mb-3">Moyen de Payement</h4>

            <div class="my-3">
              <div class="form-check">
                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" checked required>
                <label class="form-check-label" for="paypal">PayPal</label>
              </div>
              <div class="form-check">
                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                <label class="form-check-label" for="paypal">Chèque</label>
              </div>
            </div>

            <hr class="my-4">

            <input class="w-100 btn btn-primary btn-lg" type="submit" value="Valider et payer"/>
          </form>
        </div>
      </div>
    </main>