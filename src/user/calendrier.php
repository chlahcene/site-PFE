
<!DOCTYPE html>
<html>
<head>
      <?php require ( __DIR__.'/../php/_links.php') ?>



  <title>Calendrier</title>
</head>
<body>

      <?php require ( __DIR__.'/../php/_Navbar.php') ?>

  <?php
  require (__DIR__.'/../php/bdd.php');$bdd = connecterBDD();
  $req=$bdd->query('SELECT objet, dat, heure FROM notifctrl');
  ?>
       
  <br>
      <br>
      <br>

      <br>

   <h1 class="display-4" style="text-align: center">Calendrier</h1>
  <h6 class="display-6" style="text-align: center">Visualiser les dates planifiées des différentes étapes de la procédure</h6> 
  <hr class="my-4">
  
<div style="text-align: center;">
  
  <?php 

  if ($donnee=$req->fetch())
  {
     if ($donnee['dat']!=null) 
      { 
        echo '<p class="lead">Date début de procédure: <b>'.$donnee['dat'].'  '.$donnee['heure'].'</b></p>'; 
      } 
  }  

 if ($donnee=$req->fetch())
  {
     if ($donnee['dat']!=null) 
      { 
        echo '<p class="lead">Date des rappels: <b>'.$donnee['dat'].'  '.$donnee['heure'].'</b></p>'; 
      } 
  } 

  if ($donnee=$req->fetch())
  {
     if ($donnee['dat']!=null) 
      { 
        echo '<p class="lead">Date fin de procédure: <b>'.$donnee['dat'].'  '.$donnee['heure'].'</b></p>'; 
      } 
  } 
  $req->closeCursor();
  ?>

</div>
</div>
      <br>
      <br>
      <br>
      <br>
<?php
	require ( __DIR__.'/../php/_footer.php'); ?> ?>
<!--/.Footer-->
<?php require ( __DIR__.'/../php/_Scripts_home.php') ?>

</body>
</html>
