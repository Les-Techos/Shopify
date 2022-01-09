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
          <span class="badge bg-primary rounded-pill">Nombres d'article : <?= $controllerData["nbArticles"] ?></span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (Euro)</span>
            <strong><?= $controllerData["Total"] . " €" ?></strong>
          </li>
        </ul>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Adresse de facturation</h4>
        <form class="needs-validation" method="post">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Prénom</label>
              <input type="text" class="form-control" id="firstName" placeholder="" name="prenom" value="<?= $controllerData["prenom"] ?>" required onkeypress="return(testString(event));">
              <div class="invalid-feedback">
                Un prénom valide est requis
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Nom de famille</label>
              <input type="text" class="form-control" id="lastName" placeholder="" name="nom" value="<?= $controllerData["nom"] ?>" required onkeypress="return(testString(event));">
              <div class="invalid-feedback">
                Un nom valide est requis
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" name="mail" value="<?= $controllerData["mail"] ?>">
              <div class="invalid-feedback">
                Entrez un email valide.
              </div>
            </div>

            <div class="col-12">
              <label for="add1" class="form-label">Adresse</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" required name="add1" value="<?= $controllerData["add1"] ?>">
              <div class="invalid-feedback">
                Entrez une adresse d'expédition valide
              </div>
            </div>

            <div class="col-12">
              <label for="add2" class="form-label">Complément d'adresse <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Etage, code immeuble..." name="add2" value="<?= $controllerData["add2"] ?>">
            </div>

            <div class="col-12">
              <label for="add3" class="form-label">Ville</label>
              <input type="text" class="form-control" id="address" placeholder="New York" name="add3" value="<?= $controllerData["add3"] ?>" required onkeypress="return(testString(event));">
              <div class="invalid-feedback">
                Entrez une ville valide
              </div>
            </div>

            <div class="col-md-3">
              <label for="postalcode" class="form-label">Code Postal</label>
              <input type="text" class="form-control" id="zip" placeholder="" name="codepostal" value="<?= $controllerData["codepostal"] ?>" required size="5" maxlength="5" onkeypress="return(testNumerique(event));">
              <div class="invalid-feedback">
                Entrez un code postal
              </div>
            </div>

            <div class="col-md-3">
              <label for="postalcode" class="form-label">Tel</label>
              <input type="text" class="form-control" id="zip" placeholder="" name="tel" value="<?= $controllerData["tel"] ?>" required size="10" maxlength="10" onkeypress="return(testNumerique(event));">
              <div class="invalid-feedback">
                Entrez le numéro de teléphone
              </div>
            </div>
          </div>
          <br />
          <h4 class="mb-3">Adresse de Livraison</h4>

          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Prénom</label>
              <input type="text" class="form-control" id="firstName" placeholder="" name="prenomL" value="<?= $controllerData["prenomL"] ?>" required onkeypress="return(testString(event));">
              <div class="invalid-feedback">
                Un prénom valide est requis
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Nom de famille</label>
              <input type="text" class="form-control" id="lastName" placeholder="" name="nomL" value="<?= $controllerData["nomL"] ?>" required onkeypress="return(testString(event));">
              <div class="invalid-feedback">
                Un nom valide est requis
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="you@example.com" name="mailL" value="<?= $controllerData["mailL"] ?>">
              <div class="invalid-feedback">
                Entrez un email valide.
              </div>
            </div>

            <div class="col-12">
              <label for="add1" class="form-label">Adresse</label>
              <input type="text" class="form-control" id="address" placeholder="1234 Main St" name="add1L" required value="<?= $controllerData["add1L"] ?>">
              <div class="invalid-feedback">
                Entrez une adresse d'expédition valide
              </div>
            </div>

            <div class="col-12">
              <label for="add2" class="form-label">Complément d'adresse <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Etage, code immeuble..." name="add2L" value="<?= $controllerData["add2L"] ?>">
            </div>

            <div class="col-12">
              <label for="add3" class="form-label">Ville</label>
              <input type="text" class="form-control" id="address" placeholder="New York" name="add3L" value="<?= $controllerData["add3L"] ?>" onkeypress="return(testString(event));">
              <div class="invalid-feedback">
                Entrez une ville valide
              </div>
            </div>

            <div class="col-md-3">
              <label for="postalcode" class="form-label">Code Postal</label>
              <input type="text" class="form-control" id="zip" placeholder="" name="codepostalL" value="<?= $controllerData["codepostalL"] ?>" required size="5" maxlength="5" onkeypress="return(testNumerique(event));">
              <div class="invalid-feedback">
                Entrez un code postal
              </div>
            </div>
            <div class="col-md-3">
              <label for="postalcode" class="form-label">Tel</label>
              <input type="text" class="form-control" id="zip" placeholder="" name="telL" value="<?= $controllerData["telL"] ?>" required size="10" maxlength="10" onkeypress="return(testNumerique(event));">
              <div class="invalid-feedback">
                Entrez le numéro de teléphone
              </div>
            </div>
          </div>


          <hr class="my-4">

          <h4 class="mb-3">Moyen de Payement</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" value="paypal" checked required>
              <label class="form-check-label" for="paypal">PayPal</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" value="cheque" required>
              <label class="form-check-label" for="paypal">Chèque</label>
            </div>
          </div>

          <hr class="my-4">

          <input class="w-100 btn btn-primary btn-lg" type="submit" name="pay" value="Valider et payer" />
        </form>
      </div>
    </div>
  </main>