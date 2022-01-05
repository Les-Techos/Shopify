<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5>Informations du compte</h5>
                    <form method="post" action="">
                        <ul class="list-group list-group-flush">


                            <li class="list-group-item">Login : <input type="text" id="username" name="username" class="form-control" value="<?= $controllerData["username"] ?>" required /></li>
                            <li class="list-group-item">Mot de Passe : <input type="password" name="password" id="password" class="form-control" placeholder="Nouveau mot de passe" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;"></li>
                            <li class="list-group-item"><input type="password" name="cpassword" id="cpassword" class="form-control" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" placeholder="Répétez le mot de passe"></li>

                            <li class="list-group-item"><input type="submit" id="submit" name="modify" class="btn btn-alert" value="Modifier" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg">
            <div class="card" style="max-height:600px">
                <div class="card-header">Commandes à expédier </div>
                <div class="card-body">
                    <ul style="overflow-y:scroll; max-height:500px">
                        <?= $controllerData["order"] ?>
                </div>
            </div>
        </div>

    </div>
</div>