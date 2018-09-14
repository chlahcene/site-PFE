<?php require("php/_Navbar.php") ?>

<!DOCTYPE html>
<html>
<head>
	<title>Changer votre mot de passe</title>
	<?php require('php/_links.php') ?>
</head>
<body>
<br><br>
<br>
<?php
		if(isset($_GET['msg']))
		{
			if($_GET['msg'] == $_COOKIE['code'])
			{
				echo '<form method ="post" action ="/Mot_de_passe_oublie_check" align="center">
          <label for="newMdp">Nouveau mot de passe:</label><span class="glyphicon glyphicon-envelope"></span>
          <input type="password" class="form-control" id="newMdp" required="required" name="mdp" style="width: 200px; margin: 0 auto;">
<br>
          <button type="submit" name="confirmer" value="confirmer" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Confirmer</a> </button>  </div>

				<br><br>';
				if(isset($_GET['er']))
				{
					if($_GET['er'] == 'Veuillez introduire le nouveau mot de passe');
					{
						echo $_GET['er'];
					}
				}
			}
			else
			{
				header('Location: /Login');
			}
		}
	?>
<br><br>
<?php require("php/_footer.php") ?>

<?php require('php/_Scripts_home.php') ?>
</body>
</html>