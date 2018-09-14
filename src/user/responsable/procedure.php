<?php
if (!isset($form_procedure)) {
    ob_start();
	require ( __DIR__.'/../../php/_procedure_form.php');
    $form_procedure = ob_get_contents() ;
    ob_end_clean();
}

  ?>    
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
  <?php require ( __DIR__.'/../../php/_links.php') ?>
          <title>Procedure</title>
</head>
<body>
<?php require ( __DIR__.'/../../php/_Navbar.php'); ?>
 <br>
 <br>
 <div class="jumbotron" style="text-align: center;background-color: white">
  <h3 class="display-5" >Lancement de la procedure !</h3>
  <h3 class="display-5" style="color:#088A85 " >Il faut remplir tout les cases.</h3>
  <hr class="my-4">
   <div class="container col-md-8 col-lg-8">
<form>
     <?php require ( __DIR__.'/../../php/_message_flash.php') ?>
     <?= $form_procedure ?>
<div class="form-group row">
    <div class="col-sm-4 col-md-8 col-lg-8">
      <button type="submit" class="btn btn-send" style="background-color: #088A85;border: none;" >Sauvegarder</button>
    </div>
  </div>
</form>
        </div>
</div>
</div>
<!--Footer-->
<?php require ( __DIR__.'/../../php/_footer.php') ?>
<!--/.Footer-->
<?php require ( __DIR__.'/../../php/_Scripts_home.php') ?>

</body>
</html>

