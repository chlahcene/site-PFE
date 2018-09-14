<?php
 
 $role=null;

// $connecter = false;
 if (isset($_SESSION['type']))  
 	{
 		$connecter = true;
 		$role=$_SESSION['type'];
 	} 
 else $connecter=false;
if ($connecter ==true) {
  # code...
  $var = 'Deconnexion';

}elseif ($connecter ==false) {
  # code...
  $var = 'Connexion';
}

 ?>


<!DOCTYPE html>
<html class="no-js" lang="fr" dir="ltr">
<head>

    <?php require 'php/_links.php' ?>
      <title>Accueil</title>

</head>
<body>


	<?php 
	require ('php/_Navbar.php'); ?>
<br>
<br>
<br>
<?php require ("php/_message_flash.php") ?>
<?php require ("php/_jumbotron.php") ?>
<br>
<!--Footer-->
<?php require ("php/_footer.php") ?>
<!--/.Footer-->

<?php require ("php/_Scripts_home.php") ?>

</body>
</html>