<?php
if (!isset($login)) {
  $login = '';
}
if (!isset($password)) {
  $password = '';
}

  ?>

    <br>

    <label for="exampleInputEmail1">Adresse E-mail*</label>

    <br>
     <!--  <img src="../image/login.png" style="width: 9%;height: 9%"> -->

   <input value="<?=$login ?>" type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" 
   <?php if (isset($_GET['err']) &&  $_GET['err']=="adresse email incorrect") { echo ' placeholder="'.$_GET['err'].'"'; echo ' style="background-color: pink"'; }  
        else echo 'placeholder="Entrez votre adresse E-Mail"';?>>

    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mot de passe*</label>
   <br>
     <!--  <img src="../image/password.png" style="width: 9%;height: 9%"> -->

   <input  type="password" name="password" value="<?=$password ?>" class="form-control" id="exampleInputPassword1" 
   <?php if (isset($_GET['err']) &&  $_GET['err']=="mot de passe incorrect") { echo ' placeholder="'.$_GET['err'].'"'; echo ' style="background-color: pink"'; }  
        else echo 'placeholder="Entrez votre mot de passe"';?>>
   <br>
 <div style="margin-left: 5.3%">

<a style="position: absolute;margin-left: 38%;bottom: 110px" href="/Mot_de_passe_oublie"> Mot de passe oublié !</a>
  </label>

  </div>







