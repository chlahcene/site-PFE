
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Traitement du mot de passe</title>
</head>
<body>
	<?php require __DIR__.'/php/bdd.php'; 
//********************************************************************************************************************************
function envoyermailre($mail,$objet,$message_txt)
 {
  	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
	{
    	$passage_ligne = "\r\n";
	}
	else
	{
    	$passage_ligne = "\n";
	}
	$header = "From: \"SERVEUR_PFE_SOUTENANCES\"<aghimail98@gmail.com>".$passage_ligne;
	$sujet = $objet;
	$boundary = "-----=".md5(rand());
	$header.= "Reply-to: \"SERVEUR_PFE_SOUTENANCES\" <aghimail98@gmail.com>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message ="";
	//$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
 	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//ini_set("SMTP", "smtp.yahoo.fr");
	//ini_set("SMTP","smtp.gmail.com" );
	
	//ini_set('sendmail_from', 'rachidtamiti74@gmail.com'); 
	try{
		mail($mail,$sujet,$message,$header);	
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
	
  }
  


	function incrnbrconnexion($compteid,$nbrconnex)
	{
		$bdd = connecterBDD();
	$nbrconnex=$nbrconnex+1;
	$req=$bdd->prepare('UPDATE compte SET nbrconnexion= :nouvnbrconnex WHERE compteID = :compteid');
	$req->execute(array('nouvnbrconnex' => $nbrconnex,'compteid' => $compteid));
	$_SESSION['nbrconnex']+=1;
	}



	function changermotdepasse($email,$nouveaumotdepasse)
	{
		$bdd = connecterBDD();
		$req=$bdd->prepare('UPDATE compte SET Password= :nouvpass WHERE Login = :login');
		$mdp=password_hash($nouveaumotdepasse, PASSWORD_DEFAULT);
		$req->execute(array('nouvpass' => $mdp, 'login' => $email));
		$req->closeCursor();
	}

//***********************************************************************************************************************************************************
		if(isset($_POST['formu2']))
		{
			if(!preg_match("#^[a-z0-9_.-]+@esi.dz{1}?#", $_POST['email']))
				header('Location: /Mot_de_passe_oublie_check?er=L\'adresse entrée ne figure pas sur la base de données');
			else
			{
				$bdd = connecterBDD();

				$re=$bdd->prepare('SELECT * FROM compte WHERE login = ?');
				$re->execute(array($_POST['email']));

				$don = $re->fetch();
				if($don == NULL)
				{
					$re->closeCursor();
					header('Location: /Mot_de_passe_oublie?er=L\'adresse entrée ne figure pas sur la base de données');
				}
				else
				{
					$message ='Suite à une demande de réinitialisation de votre mot de passe nous envoyons ce lien ci-dessous, si vous ne reconnaissez pas';
					$message.=' l\'activité et n\'avez pas signalé avoir oublié votre mot de passe veuillez ignorer ce mail. Si oui cliquez sur le lien : <br/>';
					$message.='<a href="/Mot_de_passe_oublie?msg='.$_SESSION['ch'].'"> Lien </a>';
					//envoyermailre($_SESSION['email'],'Réinitialiser votre mot de passe',$message);
					echo '<a href="nouvea_mot_de_passe?msg='.$_SESSION['ch'].'"> Lien </a>';
					$_SESSION['email']=$_POST['email'];
					$_SESSION['id']= $don['compteID'];
					$_SESSION['nbr']= $don['nbrconnexion'];
				}
			}
			//echo $_SESSION['ch'];
		}
		if(isset($_POST['formu']))
		{
			if($_POST['mdp']==NULL)
			{
				header('Location: /Mot_de_passe_oublie?er=Veuillez introduire le nouveau mot de passe&msg='.$_SESSION['ch']);
			}
			else
			{
				changermotdepasse($_SESSION['email'],$_POST['mdp']);
				incrnbrconnexion($_SESSION['id'],$_SESSION['nbr']);
				header('Location: /login?msg=Opération réussie avec suucès');
			}
		}
	?>
</body>
</html>