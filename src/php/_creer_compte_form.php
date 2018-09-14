<?php
if (!isset($nom)) {
  $nom = '';
}
if (!isset($Prenom)) {
  $Prenom = '';
}
if (!isset($password)) {
  $password = '';
}
if (!isset($email)) {
  $email = '';
}
if (!isset($Fonction)) {
  $Fonction = '';
}
  ?>


 <div class="form-group">
    <label for="exampleFormControlSelect1">Choisir Le type</label>
    <select class="form-control col-sm-4 col-md-8 col-lg-8" id="Type">

      <option value="Admin">Admin</option>
      <option value="Responsable">Responsable</option>
      <option value="Enseignant">Enseignant</option>
      <option value="Employe">Employe</option>

    </select>
  </div>

 <div class="row" >
            <div class="col-md-4" >
                <div class="form-group" >
                    <label for="form_name">Nom *</label>
                    <input id="form_name" type="text" name="nom" value="<?=$nom ?>" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-4" >
                <div class="form-group">
                    <label for="form_lastname">Prenom *</label>
                    <input id="form_lastname" type="text" name="Prenom" value="<?=$Prenom ?>" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="form_password">Mot de passe *</label>
                    <input id="form_password" type="password" name="motpass" value="<?=$motpass ?>" class="form-control" placeholder="Please enter your password *" required="required" data-error="Valid email is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="form_password">Confirmer Mot de passe</label>
                    <input id="form_password" type="password" name="motpass" value="<?=$motpass ?>" class="form-control" placeholder="Please enter your password">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="form_email">Email *</label>
                    <input id="form_email" type="email" name="email" value="<?=$email ?>" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="form_phone">Fonction</label>
                    <input id="form_phone" type="tel" name="Fonction" value="<?=$Fonction ?>" class="form-control" placeholder="Please enter your Fonction">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>