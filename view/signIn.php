<div class="col-sm-12 ml-auto mr-auto" id="signincontent">
  <?= $controllerData ?>
  <ul class="nav nav-pills nav-fill mb-1" id="pills-tab" role="tablist">
    <li class="nav-item"> <a class="nav-link active" id="pills-signin-tab" data-toggle="pill" href="#pills-signin" role="tab" aria-controls="pills-signin" aria-selected="true">Se connecter</a> </li>
    <li class="nav-item"> <a class="nav-link" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">S'inscrire</a> </li>
  </ul>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
      <div class="col-sm-12 border border-primary shadow rounded pt-2" id="card-signin">
        <div class="text-center"><img src=".\assets\image\Web4ShopHeader.png" id="co_img" class="rounded-circle border p-1"></div>
        <form method="post" id="singninFrom">
          <div class="form-group">
            <label class="font-weight-bold">identifiant <span class="text-danger">*</span></label>
            <input type="texte" name="username" id="username" class="form-control" placeholder="Rentrer votre identifiant" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Mot de passe <span class="text-danger">*</span></label>
            <input type="password" name="password" id="password" class="form-control" placeholder="***********" required>
          </div>
          <div class="form-group">
            <input type="submit" name="submit"  id="signupsubmit" value="Se connecter" class="btn btn-block btn-primary">
          </div>
        </form>
      </div>
    </div>
    <div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab">
      <div class="col-sm-12 border border-primary shadow rounded pt-2" id="card-signin">
        <div class="text-center"><img src=".\assets\image\theImperial.jpg" class="rounded-circle border p-1"></div>
        <form method="post" id="singnupFrom" action="">
          <div class="form-group">
            <label class="font-weight-bold">Prénom <span class="text-danger">*</span></label>
            <input type="text" name="signupforname" id="signupforname" class="form-control" placeholder="Prénom" required onkeypress="return(testString(event));">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Nom <span class="text-danger">*</span></label>
            <input type="text" name="signupname" id="signupname" class="form-control" placeholder="nom" required onkeypress="return(testString(event));">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
            <input type="email" name="signupemail" id="signupemail" class="form-control" placeholder="Entrez une adresse mail valide" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Nom d'utilisateur <span class="text-danger">*</span></label>
            <input type="text" name="signupusername" id="signupusername" class="form-control" placeholder="Choississez votre nom d'utilisateur" required>
            <div class="text-danger"><em>Ce sera votre login de connexion !</em></div>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Numéro de téléphone</label>
            <input type="text" name="signupphone" id="signupphone" class="form-control" placeholder="0XXXXXXXXX" size="10" maxlength="10" onkeypress="return(testNumerique(event));">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Adresse</label>
            <input type="text" name="signupAddress" id="signupAddress" class="form-control" placeholder="Adresse (Partie 1)">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Complément d'adresse</label>
            <input type="text" name="signupCA" id="signupCA" class="form-control" placeholder="Adresse (Partie 1)">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Ville</label>
            <input type="text" name="signupCity" id="signupCity" class="form-control" placeholder="Ville" onkeypress="return(testString(event));">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Code postal</label>
            <input type="text" name="signupCP" id="signupCP" class="form-control" placeholder="Code Postal" size="5" maxlength="5" onkeypress="return(testNumerique(event));">
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Mot de passe<span class="text-danger">*</span></label>
            <input type="password" name="signuppassword" id="signuppassword" class="form-control" placeholder="***********" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;" required>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Confirmer votre Mot de passe<span class="text-danger">*</span></label>
            <input type="password" name="signupcpassword" id="signupcpassword" class="form-control" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" placeholder="***********" required>
          </div>
          <div class="form-group">
            <input type="submit" name="signupsubmit" id="signupsubmit"  value="S'inscrire" class="btn btn-block btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>