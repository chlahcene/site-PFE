<?php
if (!isset($form_login)) {
    ob_start();
    require('php/_login_form.php');
    require('php/fonctions.php');
    $form_login = ob_get_contents() ;
    ob_end_clean();
}

//mise à jour de la date de derniere connexion
if (isset($_GET['etat']))
{
  if ($_GET['etat']=='Deconnexion' && isset($_SESSION['type']))
  {   
    
    $bdd = connecterBDD();
    if ($_SESSION['type']!='employe')
    {
      $req=$bdd->prepare('UPDATE enseignant SET derniere_connexion=:dat WHERE enseignantID=:ensID');
      $req->execute(array('dat'=>date("Y-m-d H:i:s"),'ensID'=>$_SESSION['enseignantID']));
      $req->closeCursor();
    }
    foreach($_SESSION as $key=>$value)
    { 
      $_SESSION[$key]=null;
    }
    session_destroy();
  
  }
}
  ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
  <?php require('php/_links.php') ?>
	  <title>Login</title>

</head>
<body style="background-image:url(../image/background.png);background-repeat: no-repeat;   margin:0;
   padding:0;
   height:100%;">
<!--Navbar-->
<?php require("php/_Navbar.php") ?>
<!--Navbar-->
<!--Login-->
<div class="container-fluid bg " >
    <div class="row">

        <div class="col-md-4 col-sm-4 col-xs-8"></div>
        <div class="col-md-4 col-sm-4 col-xs-8">
            <form class="form-container align-middle" method="post" action="login_check" style="background-color: white;margin-top: 33%">
                <div class="form-group">
                    <h3 style="text-align: center;color: #088A85;">Login</h3>
					<?php require("php/_message_flash.php") ?>
                    <?= $form_login ?>
                      <br>
                    <button type="submit" name="formu1" class="btn btn-block" onclick="window.location.href='/'" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Connexion</a> </button>
                </div>
            </form>
        </div>
            </div class="col-md-4 col-sm-4 col-xs-8">
        </div>
<!--Login-->
<br>
<br>
<br>
<br>
<!--Footer-->
<?php require('php/_footer.php') ?>
<!--/.Footer-->
  <?php require('php/_Scripts_home.php') ?>


</body>
</html>