<!DOCTYPE html>
<html>
<head lang="fr">
	<meta charset="utf-8">
	<title>phptab2</title>
</head>
<body>
<?php
function inserdansbaseempl( $table )
{
	try
	{
		$bdd=new PDO('mysql:host=localhost;dbname=pfe;charset=utf8','root','',array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	$req0=$bdd->prepare('SELECT * FROM compte WHERE Login = :email');
	$req0->execute(array('email'=>$table['email']));
	if($donnes=$req0->fetch())
	{
		return false;
	}

	$req1= $bdd->prepare('INSERT INTO compte(Type, Login, Password, compteID, nbrconnexion) VALUES (\'employe\', :email, :pass, 0, 0)');
	$motdepasse=password_hash('emp2018', PASSWORD_DEFAULT);
	$req1->execute(array( 'email' => $table['email'], 'pass' => $motdepasse));
	$req1->closeCursor();
	$req3=$bdd->prepare('SELECT IDP FROM compte WHERE Login= ?');
	$req3->execute(array($table['email']));
	$donnees1 = $req3->fetch();
	$compteid = $donnees1['IDP'];
	$req3->closeCursor();
	$req3=$bdd->prepare('UPDATE compte SET compteID = :idcompte WHERE IDP = :idp');
	$req3->execute(array('idcompte' => $compteid, 'idp' => $compteid));
	$req3->closeCursor();
	$req= $bdd->prepare('INSERT INTO employe(NomEmploye, PrenomEmploye, FonctionEmploye, EmailEmploye, compteID, employeID) VALUES ( :nom, :prenom, :fonction, :email, :compteid, 0)');
	$req->execute(array('nom' => $table['nom'], 'prenom' => $table['prenom'], 'fonction' => $table['fonction'], 'email' => $table['email'],  
		'compteid' => $compteid));
	$req->closeCursor();
	$req=$bdd->prepare('SELECT IDP FROM employe WHERE EmailEmploye= ?');
	$req->execute(array($table['email']));
	$donnees=$req->fetch();
	$employeid=$donnees['IDP'];
	$req->closeCursor();
	$req=$bdd->prepare('UPDATE employe SET employeID = :idemp WHERE IDP = :idp');
	$req->execute(array('idemp' => $employeid, 'idp' => $employeid));
	$req->closeCursor();

	return true;
}
function creercompteemp($nomfichier)
{
	$fichier=fopen($nomfichier, 'r');
	if($fichier==NULL)
	{
		echo 'Le fichier '.$nomfichier.' n\'existe veuillez penser à l\'uploader ou verifier le nom entré';
	}
	else
	{
		$nbligne=0;
		while (!feof($fichier)) 
		{
			$ligne=fgets($fichier);
			$nbligne++;
			$cpt=0;
			$champ='';
			for ($i=0 ; $i < strlen($ligne) ; $i++) 
			{ 
				if($ligne[$i]=='#')
				{
					switch ($cpt) {
						case 0:
							$table['nom']=$champ;
							if(!preg_match("#[a-zA-z]+#", $champ))
								$cpt=12;
							break;
						case 1:
							$table['prenom']=$champ;
							if(!preg_match("#[a-zA-z]+#", $champ))
								$cpt=12;
							break;
						case 2:
							$table['fonction']=$champ;
							if(!preg_match("#[a-zA-z]+#", $champ))
								$cpt=12;
							break;
						case 3:
							if(preg_match("#^[a-z0-9_.-]+@esi.dz{1}?#", $champ))
							{
								$table['email']=$champ;
							}
							else
							{
								$cpt=10;
								echo '<br/>Addresse email non valide : <br/>';
							}
							break;
						default:
							# code...
							break;
					}
					$cpt++;
					$champ='';
				}
				else
				{
					$champ=$champ.$ligne[$i];
				}
			}
			if($cpt==4)
			{
				if(!inserdansbaseempl($table))
				{
					echo $ligne.' Ce profil existe déjà veuillez vérifier votre fichier à la ligne '.$nbligne.'<br/><br/>';
				}
				else
				{
					echo 'Création avec succés du profil : '.$table['email'].' '.$table['nom'].' '.$table['prenom'].'<br/><br/>';
				}
			}
			else
			{
				echo 'Veuillez vérifier le ligne numéro : '.$nbligne.' ----> '.$ligne.'<br/><br/>';
			}
		}
		fclose($fichier);
	}
}
creercompteemp('emp.txt');
?>
</body>
</html>