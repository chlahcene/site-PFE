

<!DOCTYPE html>
<html >
 <head>
  <title></title>
  <?php require  __DIR__.'/../../php/_links.php'; ?>
 </head>

 <body>
  <?php require __DIR__.'/../../php/_Navbar.php'; ?>
  <br>
  
  <h1 class="display-4" style="text-align: center">Planification</h1>
  <h6 class="display-6" style="text-align: center">Planifier les différentes étapes de la procédure</h6> 
  <hr class="my-4">
  <br>

<form style="margin-left: 100px" method="post" id="framework_form" action="/planification_check">

    <p> Objet de la notificaion: </p>
    <input   type="radio"  name="choix" value = "debut"   id="debut"><label for="debut"> Debut de procédure</label>
    <input type="radio" name="choix"  value= "rappel"  id="rappel" ><label for="rappel"> Rappel</label>
    <input type="radio"  name="choix"  value="fin"     id="fin"><label for="fin"> Fin de procédure</label><br><br>

    <p>date/heure d'envoi de la notification:</p>
    <input class="form-control col-md-4 col-lg-6 col-ms-12" style="width:200px" id="date" type="date" name="date" min=<?php echo date('Y-m-d');?> >
    <br>
    <input class="form-control col-md-4 col-lg-6 col-ms-12" style="width:200px" id="time" type="time" name="time"> <br><br>

    <p> Contenu de la notification: </p>
    <textarea class="form-control col-md-4 col-lg-6 col-ms-12" style="width:500px" id="two" name="contenu" COLS="10" ROWS="3" placeholder="Votre notification ici"></textarea><br><br>

	<?php if (isset($_GET['err'])) { ?><script>alert('veuillez renseigner tous les champs');</script><?php } ?>

    <button type="submit" name="Enregistrer" value="Enregistrer" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Confirmer</a> </button>

    <br><br>


</form>

 </body>
 <?php require ( __DIR__.'/../../php/_footer.php') ?>
<!--/.Footer-->
  <?php require ( __DIR__.'/../../php/_Scripts_home.php') ?>
</html>