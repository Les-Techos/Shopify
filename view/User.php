<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5>Informations du compte</h5>
                    <form method="post" action="">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nom : <input type="text" id="nom" name="nom" class="form-control" value="<?=$controllerData["nom"]?>"  required/></li>
                            <li class="list-group-item">Prénom : <input type="text" id="prenom" name="prenom" class="form-control" value="<?=$controllerData["prenom"]?>"  required/></li>
                            <li class="list-group-item">Login : <input type="text" id="username" name="username" class="form-control" value="<?=$controllerData["username"] ?>" required/></li>
                            <li class="list-group-item">Adresse : <input type="text" id="adresse1" name="adresse1" class="form-control" value="<?=$controllerData["addr1"]?>" /></li>
                            <li class="list-group-item">Complément : <input type="text" id="adresse2" name="adresse2" class="form-control" value="<?=$controllerData["addr2"]?>" /></li>
                            <li class="list-group-item">Ville : <input type="text" id="adresse3" name="adresse3" class="form-control" value="<?=$controllerData["addr3"]?>" /></li>
                            <li class="list-group-item">Code postal : <input type="text" id="postalcode" name="postalcode" class="form-control" value="<?=$controllerData["postalcode"]?>" /></li>
                            <li class="list-group-item">E-mail : <input type="text" id="mail" name="mail" class="form-control" value="<?=$controllerData["mail"]?>" required/></li>
                            <li class="list-group-item">Téléphone : <input type="text" name="phone" id="phone" class="form-control" value="<?=$controllerData["phone"]?>"></li>
                        
                            <li class="list-group-item">Mot de Passe : <input type="password" name="password" id="password" class="form-control" placeholder="Nouveau mot de passe" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;"></li>
                            <li class="list-group-item"><input type="password" name="cpassword" id="cpassword" class="form-control" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" placeholder="Répétez le mot de passe"></li>

                            <li class="list-group-item"><input type="submit" id="submit" name="modify" class="btn btn-alert" value="Modifier" /></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card" style="max-height:500px">
                <div class="card-header">Historique de commandes</div>
                <?=$controllerData["message"]?>
                <div class="card-body">
                    <ul>
                        <?=$controllerData["commandes"]?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>