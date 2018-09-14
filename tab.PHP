<!DOCTYPE html>
<html>
<head lang="fr">
	<meta charset="utf-8">
	<title>phptab</title>
</head>
<body>
<?php
function inserdansbase( $table )
{
	$bdd = connecterBDD();
	$req0=$bdd->prepare('SELECT * FROM compte WHERE Login = :email');
	$req0->execute(array('email'=>$table['email']));
	if($donnes=$req0->fetch())
	{
		return false;
	}

	$req1= $bdd->prepare('INSERT INTO compte(Type, Login, Password, compteID, nbrconnexion) VALUES (\'enseignant\', :email, :password, 0, 0)');
	$motdepasse=password_hash('ens2018', PASSWORD_DEFAULT);
	$req1->execute(array( 'email' => $table['email'], 'password' => $motdepasse));
	$req1->closeCursor();
	$req3=$bdd->prepare('SELECT IDP FROM compte WHERE Login= ?');
	$req3->execute(array($table['email']));
	$donnees1 = $req3->fetch();
	$compteid = $donnees1['IDP'];
	$req3->closeCursor();
	$req3=$bdd->prepare('UPDATE compte SET compteID = :idcompte WHERE IDP = :idp');
	$req3->execute(array('idcompte' => $compteid, 'idp' => $compteid));
	$req3->closeCursor();
	$req= $bdd->prepare('INSERT INTO enseignant(NomEnseignant, PrenomEnseignant, GradeEnseigant, EmailEnseignant, AnneeUniversitaire, compteID, enseignantID) VALUES ( :nom, :prenom, :grade, :email, :annee, :compteid, 0)');
	$req->execute(array('nom' => $table['nom'], 'prenom' => $table['prenom'], 'grade' => $table['grade'], 'email' => $table['email'], 'annee' => $table['annee'], 
		'compteid' => $compteid));
	$req->closeCursor();
	$req=$bdd->prepare('SELECT IDP FROM enseignant WHERE EmailEnseignant= ?');
	$req->execute(array($table['email']));
	$donnees=$req->fetch();
	$ensid=$donnees['IDP'];
	$req->closeCursor();
	$req=$bdd->prepare('UPDATE enseignant SET enseignantID = :idens WHERE IDP = :idp');
	$req->execute(array('idens' => $ensid, 'idp' => $ensid));
	$req->closeCursor();

	return true;
}
function creercompteens($nomfichier)
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
							if(!preg_match("#[a-zA-z]+#", $champ))
								$cpt=12;
							$table['prenom']=$champ;
							break;
						case 2:
							if(!preg_match("#[a-zA-z]+#", $champ))
								$cpt=12;
							$table['grade']=$champ;
							break;
						case 3:
							if(preg_match("#^[a-z0-9_.-]+@esi.dz{1}?#", $champ))
							{
								$table['email']=$champ;
								$table['annee']=( date('y') - 1+2000).'-'.(date('y')+2000);
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
				if(!inserdansbase($table))
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
creercompteens('ens.txt');
?>
</body>
</html>