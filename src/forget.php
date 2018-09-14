    <?php require("php/_Navbar.php") ?>
<?php
    /*
    Petit Algorithme : 
    créer une chaîne aléatoire $ch;
    stocker la chaîne dans un cookie $cook;
    evoyer un email au contact avec la chaîne comme variable transmise en lien après le '?' dans $msg;
    lorsque msg est isset(), on vérifie la conformité avec le cookie;
    si c conforme on effectue le changement
    sinon on effectue une redirection;
    */
    if(!isset($_GET['msg']))
    {
      $ch = md5(rand()).md5(rand());
      //echo $ch;
      setcookie('code', $ch, time() + 24*3600, null, null, false, true);
      $_SESSION['ch']=$ch;
      if(isset($_GET['er']))
      {
        if($_GET['er'] == 'L\'adresse entrée ne figure pas sur la base de données');
        {
          echo '<br/>'.$_GET['er'];
        }
      }
    }
?>
<?php
if (!isset($form_forget)) {
    ob_start();
	require("php/_forget_form.php");
    $form_forget = ob_get_contents() ;
    ob_end_clean();
}

  ?>
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
  
  <?php require('php/_links.php') ?>

          <title>Mot de passe Oublié</title>


</head>
<body>




 <br>
 <br>

 <div class="jumbotron" style="text-align: center;background-color: white">
  <h3 class="display-5" >Tentative de récupération de mot de passe</h3>
  <br>
  <hr class="my-4">

   <div class="container col-md-8 col-lg-8">
                    
                    <!-- We're going to place the form here in the next step -->
<!--<form id="contact-form" method="post" action="Sendmail.php" role="form" style="text-align: left;" >-->
    <div class="messages"></div>

    <div class="controls">

</div>
  <?php require("php/_message_flash.php") ?>
                    <?= $form_forget ?>

            
            </div>
        </div>
        <div class="row">
        <div class="col-md-8">
        </div>
        </div>
        </div>

<!--</form>-->
        </div>
        </div>
        </div>
  <br>

</div>



<!--Footer-->
<?php require("php/_footer.php") ?>
<!--/.Footer-->
                      

<?php require('php/_Scripts_home.php') ?>

</body>
</html>

