<?php ?>

<!DOCTYPE html>
<html>
<head>
  <?php require ( __DIR__.'/../php/_links.php'); ?>
</head>
<body>


  <?php require ( __DIR__.'/../php/_Navbar.php'); ?>
  <br>
  <br>
  <h1 class="display-4" style="text-align: center">Changer mot de passe</h1>
  <hr class="my-4">
<div class="container">
  <form method="post" action="/Changer_mot_de_passe">
      <div class="form-group" style="width: 300px;margin: 0 auto;">
          <label for="oldMdp">Ancien mot de passe:</label>
          <input type="password" class="form-control" id="ancienMdp" required="required" name="oldMdp"
				  <?php if(isset($_GET['err'])) { echo ' placeholder="'.$_GET['err'].'" style="background-color: pink"'; } ?>>

          <label for="newMdp">Nouveau mot de passe:</label><span class="glyphicon glyphicon-envelope"></span>
          <input type="password" class="form-control" id="newMdp" required="required" name="newMdp">

          <button type="submit" name="confirmer" value="confirmer" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Confirmer</a> </button>  </div>
  </form>
</div>
<br><br>
<?php //***************************************************************************************************************************************
if (isset($_POST['confirmer']))
{
   if ($_POST['oldMdp']!=$_SESSION['mdp'])
   {
    header('Location: /Changer_mot_de_passe?err=Ancien mot de passe incorrect!');
   }
   else
   {
    $motdepasseHash=password_hash($_POST['newMdp'], PASSWORD_DEFAULT);
	   require (__DIR__.'/../php/bdd.php');
    $bdd = connecterBDD();
    $req=$bdd->prepare('UPDATE compte SET Password = :Password WHERE Login = :Login');
    $req->execute(array('Password' => $motdepasseHash, 'Login' => $_SESSION['login']));
    $req->closeCursor();
    $_SESSION['mdp']=$_POST['newMdp'];
    ?><script>alert("Mot de passe changé avec succés!");</script><?php
   }
}
?>
  <br>

<?php require ( __DIR__.'/../php/_footer.php'); ?>
</body>
</html>