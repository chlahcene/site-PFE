<?php
if (!isset($form_creer_compte)) {
    ob_start();
	require __DIR__.'/../../php/_creer_compte_form.php';
    $form_creer_compte = ob_get_contents() ;
    ob_end_clean();
}

  ?>
<!DOCTYPE html>
<html class="no-js" lang="fr" dir="ltr">
<head>
  
  <?php require __DIR__.'/../../php/_links.php' ?>

          <title>Creer compte</title>

</head>
<body>

<?php require __DIR__.'/../../php/_Navbar.php'; ?>
 <br>
 <br>
 <div class="jumbotron" style="text-align: center;background-color: white">
  <h3 class="display-5" >Creer compte !</h3>
  <h3 class="display-5" style="color:#088A85 " >Il faut remplir tout les cases.</h3>
  <hr class="my-4">

   <div class="container col-md-8 col-lg-8">
                    <!-- We're going to place the form here in the next step -->
<form id="contact-form" method="post" action="" role="form" style="text-align: left;" >



    <div class="messages"></div>

    <div class="controls">
  <?php require __DIR__.'/../../php/_message_flash.php' ?>
<br>                    <?= $form_creer_compte ?>

            <div class="col-sm-4 col-md-8 col-lg-8">
<br>
                <input style="background-color: #088A85;border: none;" type="submit" class="btn btn-send" value="Creer Compte">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 col-md-8 col-lg-8">
            </div>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
  <br>
</div>


<!--Footer-->
<?php require __DIR__.'/../../php/_footer.php'; ?>
<!--/.Footer-->
                      

<?php require __DIR__.'/../../php/_Scripts_home.php'; ?>

</body>
</html>