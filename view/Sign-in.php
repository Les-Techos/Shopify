<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
 
    <title>Sign Up & Sign In form in Bootstrap 4</title>
  </head>
  <body>
     
  <div class="container mt-2 mb-4">
  <div class="col-sm-8 ml-auto mr-auto">
    <ul class="nav nav-pills nav-fill mb-1" id="pills-tab" role="tablist">
      <li class="nav-item"> <a class="nav-link active" id="pills-signin-tab" data-toggle="pill" href="#pills-signin" role="tab" aria-controls="pills-signin" aria-selected="true">Se connecter</a> </li>
      <li class="nav-item"> <a class="nav-link" id="pills-signup-tab" data-toggle="pill" href="#pills-signup" role="tab" aria-controls="pills-signup" aria-selected="false">S'inscrire</a> </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
        <div class="col-sm-12 border border-primary shadow rounded pt-2">
          <div class="text-center"><img src="..\assets\image\theImperial.jpg" class="rounded-circle border p-1"></div>
          <form method="post" id="singninFrom">
            <div class="form-group">
              <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Rentrer votre Email" required>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Mot de passe <span class="text-danger">*</span></label>
              <input type="password" name="password" id="password" class="form-control" placeholder="***********" required>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col">
                  <label><input type="checkbox" name="condition" id="condition"> Souvenez-vous de moi.</label>
                </div>
                <div class="col text-right"> <a href="javascript:;" data-toggle="modal" data-target="#forgotPass">Mot de passe oublié?</a> </div>
              </div>
            </div>
            <div class="form-group">
              <input type="submit" name="submit" value="Se connecter" class="btn btn-block btn-primary">
            </div>
          </form>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-signup" role="tabpanel" aria-labelledby="pills-signup-tab">
        <div class="col-sm-12 border border-primary shadow rounded pt-2">
          <div class="text-center"><img src="..\assets\image\theImperial.jpg" class="rounded-circle border p-1"></div>
          <form method="post" id="singnupFrom">
            <div class="form-group">
              <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
              <input type="email" name="signupemail" id="signupemail" class="form-control" placeholder="Enter valid email" required>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Nom d'utilisateur <span class="text-danger">*</span></label>
              <input type="text" name="signupusername" id="signupusername" class="form-control" placeholder="Choose your user name" required>
              <div class="text-danger"><em>Se sera votre login de connexion !</em></div>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Numéro de Tel#</label>
              <input type="text" name="signupphone" id="signupphone" class="form-control" placeholder="(000)-(0000000)">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Mot de passe<span class="text-danger">*</span></label>
              <input type="password" name="signuppassword" id="signuppassword" class="form-control" placeholder="***********" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;"
                required>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Confirmer votre Mot de passe<span class="text-danger">*</span></label>
              <input type="password" name="signupcpassword" id="signupcpassword" class="form-control" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" placeholder="***********" required>
            </div>
            <div class="form-group">
              <label><input type="checkbox" name="signupcondition" id="signupcondition" required> J'accepte les <a href="javascript:;">Termes &amp; Conditions</a> pour mon inscription.</label>
            </div>
            <div class="form-group">
              <input type="submit" name="signupsubmit" value="S'inscrire" class="btn btn-block btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="forgotPass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form method="post" id="forgotpassForm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Mot de passe oublié</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Email <span class="text-danger">*</span></label>
              <input type="email" name="forgotemail" id="forgotemail" class="form-control" placeholder="Enter your valid email..." required>
            </div>
            <div class="form-group">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Se connecter</button>
            <button type="submit" name="forgotPass" class="btn btn-primary"><i class="fa fa-envelope"></i> Send Request</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
 
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
