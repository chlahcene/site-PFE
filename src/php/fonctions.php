<?php
	require 'bdd.php';
function login($login,$motdepasse)
{
	$bdd = connecterBDD();
	$req=$bdd->prepare('SELECT * FROM compte WHERE Login= :adresse');
	$req->execute(array('adresse' => $login));
	if(!$donnes=$req->fetch())
	{
		$_SESSION['login']=null;
		return false;
	}
	else
	{
        $_SESSION['login']=$donnes['Login'];
		if($donnes['Type']=='employe')
	   {
		$req2=$bdd->prepare('SELECT * FROM employe WHERE compteID = ?');
		$req2->execute(array($donnes['compteID']));
		$donnes2=$req2->fetch();
		$id='Monsieur '.$donnes2['NomEmploye'].' '.$donnes2['PrenomEmploye'].' '.$donnes2['FonctionEmploye'];
		$req2->closeCursor();
	   }
	    else
	     {
		   $req2=$bdd->prepare('SELECT * FROM enseignant WHERE compteID = ?');
		   $req2->execute(array($donnes['compteID']));
		   $donnes2=$req2->fetch();
		   $id=$donnes2['GradeEnseigant'].' '.$donnes2['NomEnseignant'].' '.$donnes2['PrenomEnseignant'];
		   $req2->closeCursor();
	     }
	       $mdp  = $motdepasse;

	    if(password_verify($mdp,$donnes['Password']))
	     {
		   $_SESSION['mdp']=$motdepasse;
		   $_SESSION['id']=$id;
		   $_SESSION['nbrconnex']=$donnes['nbrconnexion'];
		   $req->closeCursor();
		   return true;
	     }
	    else
	     {
		   $req->closeCursor();
		   $_SESSION['mdp']=null;
		   return false;
	     }
	}
	
}



function isFicheValide($enseignantID)
{

	$bdd = connecterBDD();
	$req = $bdd->prepare('SELECT Valide FROM fichevoeux WHERE enseignantID = :enseignantID');
    $req->execute(array('enseignantID' => $enseignantID));
    if ($donnee=$req->fetch())
    {
    	if ($donnee['Valide']==1) 
    		{
    			$req->closeCursor(); 
    			return true;
    		}
    	else 
    		{   
    			$req->closeCursor();
    			return false;
    		}
    }
    else 
    	{   
            $req->closeCursor();
    		return false;
            
        }
}

function isRetardataire($ensID)
{
	$bdd = connecterBDD();
    $req=$bdd->query('SELECT objet, dat, heure FROM notifctrl WHERE objet=\'Rappel\' OR objet=\'Fin de procédure\'');	
    $donnee=$req->fetch();
    if ($donnee['dat']==null) {$req->closeCursor(); return false;}
    else 
        {
            $date_rappel=new DateTime($donnee['dat'].' '.$donnee['heure']);
            $donnee=$req->fetch();
            if ($donnee['dat']==null) {$req->closeCursor(); return false;}
            else 
                {
                    $date_fin=new DateTime($donnee['dat'].' '.$donnee['heure']);
                    $mnt=new DateTime(date("Y-m-d H:i:s"));
                    if ($mnt>$date_rappel && !isFicheValide($ensID) && $mnt<$date_fin) {$req->closeCursor(); return true;}
                    else { $req->closeCursor(); return false;}
                 }
        }
}

function calculNbNotifs($ensID)
{
	$bdd = connecterBDD();
	//recuperer la derniere date de connexion
    $req=$bdd->prepare('SELECT derniere_connexion FROM enseignant WHERE enseignantID=?');
    $req->execute(array($ensID));
    $donnee=$req->fetch();
    if ($donnee['derniere_connexion']==null) $lastConnex=new DateTime('01-01-2000 00:00:00');
    else $last_connex=new DateTime($donnee['derniere_connexion']);
    $req->closeCursor();

    //recupérer les dates des procédures
    $req=$bdd->query('SELECT objet, dat, heure FROM notifctrl');
    $cpt=0;
    while ($donnee=$req->fetch())
    {  
    	if ($donnee['dat']!=null)
    	 {  
    	    $date=new DateTime($donnee['dat'].' '.$donnee['heure']);
           
    	    if ($date>$last_connex && new DateTime(date("Y-m-d H:i:s"))>=$date)
    	    {
    	    	if ($donnee['objet']!='Rappel') {$cpt++;}
    	    }
    	 }
    }

    $req->closeCursor();
    if (!isRetardataire($ensID)) return $cpt;
    else  {echo 'ohhh yeah'; return $cpt+1;}
}




//*****************************************************************************************************************************************************************
	function suppr_string_from_tab($tab,$tai_tab,$val,&$result,&$tai_res)
//copie le tableau tab[tai_tab] dans le tableau result[tai_result] en supprimant la valeur val
	{
		$tai_res=0;
		for ($i=0;$i<$tai_tab;$i++)
		{
			if ($tab[$i]!=$val)
			{
				$result[$tai_res]=$tab[$i];
				$tai_res++;
			}
		}
	}
//******************************************************************************************************************************************************************
	function code_to_PFEID($code_pfe)//récupère le PFEID d'un code_pfe
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT PFEID FROM pfe WHERE CodePFE= ?');
		$req->execute(array($code_pfe));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['PFEID'];
		}
	}
//****************************************************************************************************************************************************************
	function PFEID_to_code($PFEID)//récupère le PFEID d'un code_pfe
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT CodePFE FROM pfe WHERE PFEID= ?');
		$req->execute(array($PFEID));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['CodePFE'];
		}
	}
//****************************************************************************************************************************************************************
	function masterID_to_code($masterID)//récupère le PFEID d'un code_pfe
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT CodeMaster FROM master WHERE masterID= ?');
		$req->execute(array($masterID));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['CodeMaster'];
		}
	}
//**************************************************************************************************************************************************************
	function PFEID_to_titre($PFEID)//récupère le PFEID d'un code_pfe
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT TitrePFE FROM pfe WHERE PFEID= ?');
		$req->execute(array($PFEID));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['TitrePFE'];
		}
	}
//****************************************************************************************************************************************************************
	function masterID_to_titre($masterID)//récupère le PFEID d'un code_pfe
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT TitreMaster FROM master WHERE masterID= ?');
		$req->execute(array($masterID));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['TitreMaster'];
		}
	}

//****************************************************************************************************************************************************************
	function code_to_masterID($code_master)//recupere le masterID d'un code_master
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT masterID FROM master WHERE CodeMaster= ?');
		$req->execute(array($code_master));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['masterID'];
		}
	}
//****************************************************************************************************************************************************************
	function new_fiche_voeux_id() //retourne le ficheVoeuxID à utiliser pour une prochaine fiche de voeux remplie
	{
		$bdd = connecterBDD();
		$req = $bdd->query('SELECT ficheVoeuxID FROM fichevoeux ORDER BY fichevoeuxID DESC');
		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return 1;
		}
		else {
			$req->closeCursor();
			return $donnees['ficheVoeuxID']+1;
		}
	}
//***************************************************************************************************************************************************************
	function get_ens_id_by_email($email) //retourne l'enseignantID d'un enseignant en connaissant son email
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT enseignantID FROM enseignant WHERE EmailEnseignant=?');
		$req->execute(array($email));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['enseignantID'];
		}
	}
//****************************************************************************************************************************************************************
	function get_fichevoeuxID_by_ensID($ensID)
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT ficheVoeuxID FROM fichevoeux WHERE enseignantID=?');
		$req->execute(array($ensID));

		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else {
			$req->closeCursor();
			return $donnees['ficheVoeuxID'];
		}
	}
//**************************************************************************************************************************************************************
	function getNomPrenomEnsByID($ensID)
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT NomEnseignant, PrenomEnseignant FROM enseignant WHERE enseignantID=?');
		$req->execute(array($ensID));
		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else
		{
			$req->closeCursor();
			return $donnees['NomEnseignant'].' '.$donnees['PrenomEnseignant'];
		}
	}
//*************************************************************************************************************************************************************
	function getNomPrenomEnsByficheVoeuxID($ficheVoeuxID)
	{
		$bdd = connecterBDD();
		$req = $bdd->prepare('SELECT enseignantID FROM fichevoeux WHERE ficheVoeuxID=?');
		$req->execute(array($ficheVoeuxID));
		if (!($donnees = $req->fetch()))
		{
			$req->closeCursor();
			return (-1);
		}
		else
		{
			$req->closeCursor();
			return getNomPrenomEnsByID($donnees['enseignantID']);
		}
	}
//**************************************************************************************************************************************************************
	function get_choix_by_spec($specialite,$i,$ficheVoeuxID)
//donne le code pfe/master du ieme choix fait dans la spécialité donnée dans la fiche de voeux caractérisée par ficheVoeuxID
//$specialite ϵ {SIT,SIQ,SIL,MIXTE,MASTER}
	{
		if ($specialite=='SIT' || $specialite=='SIQ' || $specialite=='SIL' || $specialite=='MIXTE')
		{
			$bdd = connecterBDD();
			$reponse = $bdd->prepare('SELECT choixpfe.ordre, pfe.SpecialitePFE, pfe.CodePFE  
                                  FROM choixpfe
                                  INNER JOIN pfe
                                  ON pfe.PFEID = choixpfe.PFEID 
                                  WHERE choixpfe.ficheVoeuxID= ? AND choixpfe.ordre= ? AND pfe.SpecialitePFE= ?');
			$reponse->execute(array($ficheVoeuxID,$i,$specialite));
			if ($donnees=$reponse->fetch()) $res=$donnees['CodePFE'];
			else $res='';
			$reponse->closeCursor();
			return $res;
		}
		else if ($specialite=='MASTER' || $specialite=='Master')
		{
			$bdd = connecterBDD();
			$reponse = $bdd->prepare('SELECT choixmaster.ordre, master.CodeMaster 
                                  FROM choixmaster
                                  INNER JOIN master
                                  ON master.masterID = choixmaster.masterID 
                                  WHERE choixmaster.ficheVoeuxID= ? AND choixmaster.ordre= ?');
			$reponse->execute(array($ficheVoeuxID,$i));
			if ($donnees=$reponse->fetch()) $res=$donnees['CodeMaster'];
			else $res='';
			$reponse->closeCursor();
			return $res;
		}
	}
//*****************************************************************************************************************************************************************
	function get_titre_by_spec($specialite,$i,$ficheVoeuxID)
	{
		if ($specialite=='SIT' || $specialite=='SIQ' || $specialite=='SIL' || $specialite=='MIXTE')
		{
			$bdd = connecterBDD();
			$reponse = $bdd->prepare('SELECT choixpfe.ordre, pfe.SpecialitePFE, pfe.TitrePFE  
                                  FROM choixpfe
                                  INNER JOIN pfe
                                  ON pfe.PFEID = choixpfe.PFEID 
                                  WHERE choixpfe.ficheVoeuxID= ? AND choixpfe.ordre= ? AND pfe.SpecialitePFE= ?');
			$reponse->execute(array($ficheVoeuxID,$i,$specialite));
			if ($donnees=$reponse->fetch()) $res=$donnees['TitrePFE'];
			else $res='';
			$reponse->closeCursor();
			return $res;
		}
		else if ($specialite=='MASTER' || $specialite=='Master')
		{
			$bdd = connecterBDD();
			$reponse = $bdd->prepare('SELECT choixmaster.ordre, master.TitreMaster 
                                  FROM choixmaster
                                  INNER JOIN master
                                  ON master.masterID = choixmaster.masterID 
                                  WHERE choixmaster.ficheVoeuxID= ? AND choixmaster.ordre= ?');
			$reponse->execute(array($ficheVoeuxID,$i));
			if ($donnees=$reponse->fetch()) $res=$donnees['TitreMaster'];
			else $res='';
			$reponse->closeCursor();
			return $res;
		}
	}
//****************************************************************************************************************************************************************

	function rech_specialite($specialite,$type,&$result,&$titre) //retourne un tableau $result[] de chemins des PFE/MASTER d'une specialité donnée
	{ //$specialite ={sit,siq,sil,mixte,master}
		$bdd = connecterBDD();
		$j=0;
		if (strSearch('pfe',$type))
		{
			$req=$bdd->query('SELECT * from pfe');
			while($donnee=$req->fetch())
			{
				if (strSearch($donnee['SpecialitePFE'],$specialite))
				{
					$result[$j]=$donnee['chemin'];
					$titre[$j]=$donnee['TitrePFE'];
					$j++;
				}
			}
		}
		if (strSearch('master',$type))
		{
			$req=$bdd->query('SELECT * from master');
			while($donnee=$req->fetch())
			{
				if (strSearch($donnee['SpecialiteMaster'],$specialite))
				{
					$result[$j]=$donnee['chemin'];
					$titre[$j]=$donnee['TitreMaster'];
					$j++;
				}
			}
		}
		$req->closeCursor();
	}
//********************************************************************************************************************************************
	function rech_titre($titre,&$result,&$title)
		//retourne un tableau $result[] de chemins des PFE/MASTER correspondant au titre ou à une partie du titre donné
	{
		$bdd = connecterBDD();
		$req = $bdd->query('SELECT chemin, TitrePFE FROM pfe');

		$i=0;
		while ($donnee=$req->fetch())
		{
			if (stripos($donnee['TitrePFE'],$titre)!==false)
			{
				$result[$i]=$donnee['chemin'];
				$title[$i]=$donnee['TitrePFE'];
				$i++;
			}
		}
		$req->closeCursor();


		$req = $bdd->query('SELECT chemin, TitreMaster FROM master');

		while ($donnee=$req->fetch())
		{
			if (stripos($donnee['TitreMaster'],$titre)!==false)
			{
				$result[$i]=$donnee['chemin'];
				$title[$i]=$donnee['TitreMaster'];
				$i++;
			}
		}
		$req->closeCursor();

	}
	//**************************************************************************************************************************************

	function strSearch($chaine,$tab_sous_chaine) //retourne true si une des sous-chaines du tableau de chaine $tab_sous_chaine est incluse dans $chaine
	{
		$tai=count($tab_sous_chaine);
		$i=0;
		$trouv=false;
		while ($i+1<=$tai && !$trouv)
		{
			if (stripos($chaine,$tab_sous_chaine[$i])!==false) $trouv=true;
			else $i++;
		}
		return $trouv;
	}
	//*************************************************************************************************************************************
	function rech_mots_cles($mots_cles,&$result,&$titre)
		//retourne un tableau $result[] de chemins des PFE/MASTER ayant au moins un des mots clés présents dans le tableau $mots_cles[] (booleen OU)
	{
		$bdd = connecterBDD();

		//$tai=count($mots_cles); //recuperer la taille du tableau des mots clés
		//suppr_string_from_tab($mots_cles,$tai,'',$mots_cles_sans_vide,$tai_res);

		$i=0;
		$req=$bdd->query('SELECT chemin, mots_cles,TitrePFE from pfe');
		while($donnee=$req->fetch())
		{
			if (strSearch($donnee['mots_cles'],$mots_cles))
			{
				$result[$i]=$donnee['chemin'];
				$titre[$i]=$donnee['TitrePFE'];
				$i++;
			}
		}

		$req=$bdd->query('SELECT chemin, mots_cles,TitreMaster from master');
		while($donnee=$req->fetch())
		{
			if (strSearch($donnee['mots_cles'],$mots_cles))
			{
				$result[$i]=$donnee['chemin'];
				$titre[$i]=$donnee['TitreMaster'];
				$i++;
			}
		}
		$req->closeCursor();
	}
//********************************************************************************************************************************************
	function enregFiche() //remplit la table fichevoeux sans valider
	{

//recuperer l'anneee universitaire actuelle.
		$annee_universitaire=(string)(date('Y')-1);
		$annee_universitaire.='/'.date('Y');

//recupérer la date et l'heure actuelles:
		$date=date("Y-m-d H:i:s");

//remplir la table ficheVoeux si pas encore fait
		if ($_SESSION['ficheVoeuxID']==-1 || $_SESSION['ficheVoeuxID']==0) //ou null
		{
			$_SESSION['ficheVoeuxID']=new_fiche_voeux_id();//générer l'id de la fiche de voeux
			$_SESSION['Valide']=0;

//requete d'insertion:
			$bdd = connecterBDD();
			$req = $bdd->prepare('INSERT INTO fichevoeux(AnneeUniversitaire, DateRemise, enseignantID, ficheVoeuxID, Valide) VALUES(:AnneeUniversitaire, :DateRemise, :enseignantID, :ficheVoeuxID, :Valide)');
			$req->execute(array(
					'AnneeUniversitaire' => $annee_universitaire,
					'DateRemise' => $date,
					'enseignantID' => $_SESSION['enseignantID'],
					'ficheVoeuxID' => $_SESSION['ficheVoeuxID'],
					'Valide' => 0
			));
			$req->closeCursor();
		}

		else {//ficheVoeux déja identifié par un id => on met à jour la date de la derniere modification dans la table ficheVoeux
			$bdd = connecterBDD();
			//requete de mise à jour de dateRemise
			$req = $bdd->prepare('UPDATE fichevoeux SET DateRemise = :DateRemise WHERE ficheVoeuxID = :ficheVoeuxID');
			$req->execute(array(
					'DateRemise' => $date,
					'ficheVoeuxID' => $_SESSION['ficheVoeuxID']
			));
			$req->closeCursor();
		}
	}
//******************************************************************************************************************************************************
	function modifFiche($choix_sit,$choix_siq,$choix_sil,$choix_mixte,$choix_master)
//modifie les tables choixpfe et choixmaster avec les valeurs renseignées dans les tableaux en entrée
	{

		$bdd = connecterBDD();
		//suppression des anciens choix dans la table choixpfe:
		$req = $bdd->prepare('DELETE FROM choixpfe WHERE ficheVoeuxID = :ficheVoeuxID');
		$req->execute(array(
				'ficheVoeuxID' => $_SESSION['ficheVoeuxID']
		));
		$req->closeCursor();

		//suppression des anciens choix dans la table choixmaster:
		$req = $bdd->prepare('DELETE FROM choixmaster WHERE ficheVoeuxID = :ficheVoeuxID');
		$req->execute(array(
				'ficheVoeuxID' => $_SESSION['ficheVoeuxID']
		));
		$req->closeCursor();

		//renseigner la taille des tableaux:
		$tai_SIT=count($choix_sit);
		$tai_SIQ=count($choix_siq);
		$tai_SIL=count($choix_sil);
		$tai_MXT=count($choix_mixte);
		$tai_MASTER=count($choix_master);

		for ($i=0;$i<10;$i++) //parcourir tout les tableaux de choix
		{
			$ordre=$i+1; //mettre à jour l'ordre du choix

			if ($i+1<=$tai_SIT) //tableau SIT pas encore parcouru complètement
			{
				//requete d'insertion des choix SIT dans la table choixpfe
				$PFEID=code_to_PFEID($choix_sit[$i]);
				$req = $bdd->prepare('INSERT INTO choixpfe(ordre, ficheVoeuxID, PFEID) VALUES(:ordre, :ficheVoeuxID, :PFEID)');
				$req->execute(array(
						'ordre' => $ordre,
						'ficheVoeuxID' => $_SESSION['ficheVoeuxID'],
						'PFEID' => $PFEID
				));
				$req->closeCursor();
			}
			if ($i+1<=$tai_SIQ)
			{
				$PFEID=code_to_PFEID($choix_siq[$i]);
				$req = $bdd->prepare('INSERT INTO choixpfe(ordre, ficheVoeuxID, PFEID) VALUES(:ordre, :ficheVoeuxID, :PFEID)');
				$req->execute(array(
						'ordre' => $ordre,
						'ficheVoeuxID' =>$_SESSION['ficheVoeuxID'],
						'PFEID' => $PFEID
				));
				$req->closeCursor();

			}
			if ($i+1<=$tai_SIL)
			{
				$PFEID=code_to_PFEID($choix_sil[$i]);
				$req = $bdd->prepare('INSERT INTO choixpfe(ordre, ficheVoeuxID, PFEID) VALUES(:ordre, :ficheVoeuxID, :PFEID)');
				$req->execute(array(
						'ordre' => $ordre,
						'ficheVoeuxID' => $_SESSION['ficheVoeuxID'],
						'PFEID' => $PFEID
				));
				$req->closeCursor();

			}
			if ($i+1<=$tai_MXT)
			{
				$PFEID=code_to_PFEID($choix_mixte[$i]);
				$req = $bdd->prepare('INSERT INTO choixpfe(ordre, ficheVoeuxID, PFEID) VALUES(:ordre, :ficheVoeuxID, :PFEID)');
				$req->execute(array(
						'ordre' => $ordre,
						'ficheVoeuxID' => $_SESSION['ficheVoeuxID'],
						'PFEID' => $PFEID
				));
				$req->closeCursor();

			}
			if ($i+1<=$tai_MASTER)
			{
				$masterID=code_to_masterID($choix_master[$i]);
				$req = $bdd->prepare('INSERT INTO choixmaster(ordre, ficheVoeuxID, masterID) VALUES(:ordre, :ficheVoeuxID, :masterID)');
				$req->execute(array(
						'ordre' => $ordre,
						'ficheVoeuxID' => $_SESSION['ficheVoeuxID'],
						'masterID' => $masterID
				));
				$req->closeCursor();
			}

		}
	}
//***********************************************************************************************************************************************************
	function validFiche()//mettre le champ valide de la table fichevoeux à 1
	{
		if ($_SESSION['ficheVoeuxID']!=(-1) && $_SESSION['ficheVoeuxID']!=0 && $_SESSION['valide']==0) //fiche de voeux renseignée et pas encore validée
		{
			$_SESSION['Valide']=1;
			$bdd = connecterBDD();
			//requete de mise à jour du champ "valide"
			$req = $bdd->prepare('UPDATE fichevoeux SET Valide = :Valide WHERE ficheVoeuxID = :ficheVoeuxID');
			$req->execute(array(
					'Valide' => 1,
					'ficheVoeuxID' => $_SESSION['ficheVoeuxID']
			));
		}

	}
//****************************************************************************************************************************************************************
	function tronq_tab($tab,$tai_res,&$result)//tronque le tableau $tab à la taille $tai_res et met le résultat dans $result
	{
		$result= array();
		for($i=0;$i<$tai_res;$i++)
		{
			$result[$i]=$tab[$i];
		}
	}

	function suppr_tab_doublons($tab,&$result) //extrait les valeurs uniques du tableau $tab dans $result
	{
		$tai_tab=count($tab);
		$result= array();
		if ($tai_tab!=0){
			$j=0;
			for($i=0;$i<$tai_tab;$i++)
			{
				if (!in_array($tab[$i],$result))
				{
					$result[$j]=$tab[$i];
					$j++;
				}
			}
		}
	}
//**************************************************************************************************************************************************************
	function incNbChoixPFE($CodePFE)
	{
		$bdd = connecterBDD();
		//requete d'incrémentation du nombre de choix:
		$req = $bdd->prepare('UPDATE pfe SET NbChoix = NbChoix+1 WHERE CodePFE = :CodePFE');
		$req->execute(array(
				'CodePFE' => $CodePFE ));
		$req->closeCursor();
	}
//**************************************************************************************************************************************************************
	function incNbChoixMaster($CodeMaster)
	{
		$bdd = connecterBDD();
		//requete d'incrémentation du nombre de choix:
		$req = $bdd->prepare('UPDATE master SET NbChoix = NbChoix+1 WHERE CodeMaster = :CodeMaster');
		$req->execute(array(
				'CodeMaster' => $CodeMaster));
		$req->closeCursor();
	}
//**************************************************************************************************************************************************************
	function intToString($n,$nbposition) //convertit un entier en chaine sur nbposition position (remplissage avec des 0)
	{
		$result=null;
		if (strlen((string)$n)<$nbposition)
		{
			$result=(string)$n;
			while (strlen((string)$result)!=$nbposition)
			{
				$result='0'.$result;
			}
		}

		return $result;
	}
//******************************************************************************************************************************************************************
	function recupCodePFEMASTER($nomFichier)//recupere le code pfe/master depuis un fichier xml situé dans le chemin $chemin
	{
		return preg_replace('/.xml/','',$nomFichier);
	}
//****************************************************************************************************************************
	function recupTitre($nomFichier)//recupere le titre du pfe
	{
		$xml=simplexml_load_file('../../espace_enseignant/PfeMasterUploaded/'.$nomFichier);
		if (!isMaster($nomFichier))
		{
			$tab=$xml->informaltable->tgroup->tbody->row[0]->entry->para;
			foreach ($tab as $chaine) if (preg_match('/TITRE :/i',$chaine)) return preg_replace('/TITRE :/','',$chaine);
		}

		else{
			$tab=$xml->para;
			foreach($tab as $chaine) if (preg_match('/Thème du master :/i',$chaine)) return preg_replace('/Thème du master :/i','',$chaine);
		}
	}
//****************************************************************************************************************************
	function recupMotsCles($nomFichier)
	{
		$xml=simplexml_load_file('../../espace_enseignant/PfeMasterUploaded/'.$nomFichier);

		if (!isMaster($nomFichier))
		{
			$tab=$xml->informaltable->tgroup->tbody->row[1]->entry->para;

			$trouv=false;
			foreach ($tab as $chaine)
			{
				if (preg_match('/Mots clés/i',$chaine) && !$trouv)
				{
					$mots_cles=$chaine;
					$trouv=true;
				}
				else if ($trouv)
				{
					$mots_cles.=$chaine;
				}
			}
			return preg_replace('/Mots clés : /','',$mots_cles);
		}
		else
		{

			$tab=$xml->para;

			$trouv=false;
			foreach ($tab as $chaine)
			{

				if ((preg_match('/Mots clés/i',$chaine) || preg_match('/Mots clé/i',$chaine)) && !$trouv)
				{
					$mots_cles=$chaine;
					$trouv=true;
					if (preg_match('/Mots clés/i',$chaine)) $cpt=1;
					else $cpt=2;
				}
				else if ($trouv)
				{
					$mots_cles.=$chaine;
				}
			}
			if (isset($cpt))
			{
				if ($cpt==1) return preg_replace('/Mots clés : /','',$mots_cles);
				else return preg_replace('/Mots clé : /','',$mots_cles);
			}
			else return ' ';
		}
	}
//*****************************************************************************************************************************
	function recupChemin($nomFichier) //récupere le chemin relatif des pdfs
	{
		$CodePFE=preg_replace('/.xml/','',$nomFichier);
		if(preg_match("/msit/i",$CodePFE) || preg_match("/msiq/i",$CodePFE) || preg_match("/msil/i",$CodePFE) || preg_match("/mmxt/i",$CodePFE))
		{return '"../../pfemaster/sujetsMASTER/'.$CodePFE.'.pdf"';}
		else if(preg_match("/siq/i",$CodePFE)) return '"../../pfemaster/sujetsSIQ/'.$CodePFE.'.pdf"';
		else if(preg_match("/sil/i",$CodePFE)) return '"../../pfemaster/sujetsSIL/'.$CodePFE.'.pdf"';
		else if(preg_match("/mxt/i",$CodePFE)) return '"../../pfemaster/sujetsMXT/'.$CodePFE.'.pdf"';
		else if(preg_match("/sit/i",$CodePFE)) return '"../../pfemaster/sujetsSIT/'.$CodePFE.'.pdf"';
	}
//****************************************************************************************************************************
	function recupSpecialite($nomFichier) //recupere la specialité du pfe/master
	{
		$CodePFE=preg_replace('/.xml/','',$nomFichier);
		if(preg_match("/siq/i",$CodePFE)) return "SIQ";
		else if(preg_match("/sil/i",$CodePFE)) return "SIL";
		else if(preg_match("/mxt/i",$CodePFE)) return "MIXTE";
		else if(preg_match("/sit/i",$CodePFE)) return "SIT";
	}
//*****************************************************************************************************************************
	function isMaster($nomFichier)//renvoie vrai si le fichier en question est une soutenance master et faux sinon
	{
		$CodePFE=preg_replace('/.xml/','',$nomFichier);
		if(preg_match("/msit/i",$CodePFE) || preg_match("/msiq/i",$CodePFE) || preg_match("/msil/i",$CodePFE) || preg_match("/mmxt/i",$CodePFE))
		{return true;}
		else return false;
	}
//******************************************************************************************************************************
	function generID_PFEMASTER($nomFichier) //attribue un id séquentiel à chaque fiche descriptive pfe/master
	{
		$bdd = connecterBDD();
		if (!isMaster($nomFichier))
		{
			$req=$bdd->query("SELECT PFEID from pfe ORDER BY PFEID DESC");
			if (!$donnees=$req->fetch()) return 1; //table des pfes vide
			else {
				$result=$donnees['PFEID']+1;
				$req->closeCursor();
				return $result;
			}
		}
		else {
			$req=$bdd->query("SELECT masterID from master ORDER BY masterID DESC");
			if (!$donnees=$req->fetch()) return 1; //table des masters vide
			else {
				$result=$donnees['masterID']+1;
				$req->closeCursor();
				return $result;
			}
		}
	}
//******************************************************************************************************************************
	function extractInfoFiche($nomFichier,&$tabInfo)//extrait toutes les infos nécessaiores du fichier xml et les range dans un tableau $tabInfo
	{
		$tabInfo['isMaster']=isMaster($nomFichier);
		$tabInfo['Code']=recupCodePFEMASTER($nomFichier);
		$tabInfo['Titre']=recupTitre($nomFichier);
		$tabInfo['mots_cles']=recupMotsCles($nomFichier);
		$tabInfo['Specialite']=recupSpecialite($nomFichier);
		$tabInfo['ID']=generID_PFEMASTER($nomFichier);
		$tabInfo['chemin']=recupChemin($nomFichier);

		echo '<pre>';
		print_r($tabInfo);
		echo '</pre>';
	}
//*******************************************************************************************************************
	function non_rafrechissement() // permet de gerer un formulaire sans renvoyer les informations apres rafrechissement
	{



		// { Début - Première partie
		if(!empty($_POST) OR !empty($_FILES))
		{
			$_SESSION['sauvegarde'] = $_POST ;
			$_SESSION['sauvegardeFILES'] = $_FILES ;

			$fichierActuel = $_SERVER['PHP_SELF'] ;
			if(!empty($_SERVER['QUERY_STRING']))
			{
				$fichierActuel .= '?' . $_SERVER['QUERY_STRING'] ;
			}

			header('Location: ' . $fichierActuel);
			exit;
		}
		// } Fin - Première partie

		// { Début - Seconde partie
		if(isset($_SESSION['sauvegarde']))
		{
			$_POST = $_SESSION['sauvegarde'] ;
			$_FILES = $_SESSION['sauvegardeFILES'] ;

			unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
		}
		// } Fin - Seconde partie
	}
	function option_visualisation($table,$spec) /// permet de renvoyer les sujets de la table $table dans la specialite $spec sous forme d'options de liste de deroulante
	{
		$bdd = connecterBDD();

		// Si tout va bien, on peut continuer

		// On récupère tout le contenu de la table jeux_video
		if ($table=='master') $reponse = $bdd->query('SELECT * FROM master');
		if ($table=='pfe') $reponse = $bdd->query('SELECT * FROM pfe');
		if ($spec=='') echo '<option>'.'Tout les sujets  '.$table.'</option><br/>' ;
		else echo '<option>'.'Sujet  '.$table.'  specialité  '.$spec.'</option><br/>' ;

		// On affiche chaque entrée une à une
		while ($donnees = $reponse->fetch())
		{
			if ($table=='master')
			{
				if (($donnees["SpecialiteMaster"]==$spec) || ($spec=='')) echo '<option>'.$donnees["TitreMaster"]."   ____   ".$donnees["SpecialiteMaster"].'</option><br/>' ;
			}
			if ($table=='pfe')
			{
				if (($donnees["SpecialitePFE"]==$spec) || ($spec=='')) echo '<option>'.$donnees["TitrePFE"]."   ____   ".$donnees["SpecialitePFE"].'</option><br/>' ;
			}

		}

		$reponse->closeCursor(); // Termine le traitement de la requête
	}
//***********************************************************************************************************************
	function recherche_sujet(&$tai)
	{
		//on recupere dans un tableau les donnes qui ont etaient saisis par l'utilisateur (les criteres de recherche)
		$type[0]='';
		$spec[0]='';
		$i=0;
		if (isset($_POST['master']))
		{
			$type[$i]='master';
			$i++;
		}
		if (isset($_POST['pfe']))
		{
			$type[$i]='pfe';
			$i++;
		}
		$i=0;
		if (isset($_POST['SIT']))
		{
			$spec[$i]='SIT';
			$i++;
		}
		if (isset($_POST['SIQ']))
		{
			$spec[$i]='SIQ';
			$i++;
		}
		if (isset($_POST['SIL']))
		{
			$spec[$i]='SIL';
			$i++;
		}
		if (isset($_POST['MIXTE']))
		{
			$spec[$i]='MIXTE';
			$i++;
		}

		$tai=0; // le nombre de resultats de la recherche
		if (isset($_POST['master']) || isset($_POST['pfe']))
		{
			if (isset($_POST['SIT']) || isset($_POST['SIQ']) || isset($_POST['SIL']) || isset($_POST['MIXTE']))
			{
				$result_spec=[];
				$titre_spec=[];
				rech_specialite($spec,$type,$result_spec,$titre_spec);
				//$tai=count($result_spec);
				//echo '<br>','-nombre de resultats spec  : '.$tai;
				//for ($i=0;$i<$tai;$i++) echo '<br>'.$i.' - ','<a href='.$result_spec[$i].' target="_blank">'.$result_spec[$i].'</a>';
				$result_mc=[];
				$titre_mc=[];
				if (isset($_POST['mots_cles']))
				{
					rech_mots_cles($_POST['mots_cles'],$result_mc,$titre_mc);
				}

				$result_titre=[];
				$titre_titre=[];
				if (isset($_POST['titre']))
				{
					rech_titre($_POST['titre'],$result_titre,$titre_titre);
				}
				$result=$result_spec;
				$titre=$titre_spec;
				if (($_POST['mots_cles'][0]!=='')||($_POST['mots_cles'][1]!=='')||($_POST['mots_cles'][2]!=='')) //si on a saisis au moins un mot cle
				{
					$result=array_intersect($result_mc, $result_spec);
					$titre=array_intersect($titre_mc, $titre_spec);
				}
				if ($_POST['titre']!=='') // si on a saisis un titre
				{
					$result=array_intersect($result_titre, $result);
					$titre=array_intersect($titre_titre, $titre);
				}
				$tai=count($result); // on recuprere le nombre de resultats= taille du tableau $result
				$i=0;
				//echo '<legend>Les resultats de la recherche</legend>';
				$bdd = connecterBDD();

				foreach($result as $cle=>$valeur)
				{
					$i++;
					echo '<br>'."_".'<option value='.$valeur.'>'.$titre[$cle].'</option>';

				}


			}
		}
		echo '<br>','Nombre de resultats  : '.$tai;//on imprime le nombre de resultats de la recherche

	}

	function envoyermail($mail,$objet,$message_txt)
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
		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
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

	//****************************************************************************************************************************
	function nbrSujetMaster(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT COUNT(*) FROM master ');
		$donnes = $req->fetch();
		$nbrmaster = $donnes['0'];
		$req->closeCursor();
		return (int)$nbrmaster;
	}
	function nbrEnsignant(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT COUNT(*) FROM enseignant ');
		$donnes = $req->fetch();
		$nbrenseignant = $donnes['0'];
		$req->closeCursor();
		return (int)$nbrenseignant;
	}
	function nbrEnsignantValider(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT COUNT(*) FROM fichevoeux ');
		$donnes = $req->fetch();
		$nbrfichevoeux = $donnes['0'];
		$req->closeCursor();
		return (int)$nbrfichevoeux;
	}
	function nbrSujetPfe(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT COUNT(*) FROM pfe');
		$donnes = $req->fetch();
		$nbrpfe = $donnes['0'];
		$req->closeCursor();
		return (int)$nbrpfe;
	}
	function listSujetPfe(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT * FROM pfe ORDER BY NbChoix ASC');
		//$req=$bdd->query('SELECT * FROM pfe');
		$donnespfe=$req->fetchall();
		$req->closeCursor();
		return $donnespfe;
	}
	function listSujetMaster(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT * FROM master ORDER BY NbChoix ASC');
		//$req=$bdd->query('SELECT * FROM master');
		$donnespfe=$req->fetchall();
		$req->closeCursor();
		return $donnespfe;
	}
	function listFicheVoeux(){
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT * FROM fichevoeux WHERE Valide=1 ORDER BY DateRemise ASC');
		$donnesfiche=$req->fetchall();
		$i=0;
		while (isset($donnesfiche[$i])) {
			$req1=$bdd->prepare('SELECT * FROM choixpfe WHERE ficheVoeuxID=:ficheVoeuxID ORDER BY ordre');
			$req1->execute(array('ficheVoeuxID'=>$donnesfiche[$i]['ficheVoeuxID']));
			$choixpfe=$req1->fetchall();
			$donnesfiche[$i]['choixpfe']=$choixpfe;
			$req2=$bdd->prepare('SELECT * FROM choixmaster WHERE ficheVoeuxID=:ficheVoeuxID ORDER BY ordre');
			$req2->execute(array('ficheVoeuxID'=>$donnesfiche[$i]['ficheVoeuxID']));
			$choixmaster=$req2->fetchall();
			$donnesfiche[$i]['choixmaster']=$choixmaster;
			$i++;
		}
		$req->closeCursor();
		return $donnesfiche;
	}
	function insertJuryPfes(array $juryPfes){
		// fprm est sujetID => array (ensID,ensID ...)
		$bdd = connecterBDD();
		$req=$bdd->query('DELETE FROM jurypfe');
		$req=$bdd->prepare('INSERT INTO jurypfe(enseignantID, PFEID) VALUES( :ensid, :pfeid) ');
		foreach ($juryPfes as $sujetID => $ensignant){
			foreach ($ensignant as $i => $ensid ){
				$req->execute(array('ensid' => $ensid, 'pfeid' => $sujetID));
			}
		}
		$req->closeCursor();
	}
	function insertJuryMasters(array $juryMasters){
		// fprm est sujetID => array (ensID,ensID ...)
		$bdd = connecterBDD();
		$req=$bdd->query('DELETE FROM jurymaster');
		$req=$bdd->prepare('INSERT INTO jurymaster(enseignantID, masterID) VALUES( :ensid, :masterid) ');
		foreach ($juryMasters as $sujetID => $ensignant){
			foreach ($ensignant as $i => $ensid ){
				$req->execute(array('ensid' => $ensid, 'masterid' => $sujetID));
			}
		}
		$req->closeCursor();
	}
	function suprimeColonne(array &$tab,$indice,$value){
		//echo '<br> sl'.count($tab).'<br>';
		//var_dump($tab);
		//var_dump($indice,$value);
		foreach ($tab as $i => $valuer){
			if (isset($valuer[$indice])){
				if ($valuer[$indice]==$value){
					//echo "va";
					unset($tab[$i]);
					break;
				}
			}
		}
		//var_dump($tab);
		//echo '<br>sl'.count($tab).'<br>';
		//die();
	}
	function propositionTemp(){
		// propostion para rapport les temp et premier choix
		$listSujetPfe = listSujetPfe();
		//var_dump($listSujetPfe);
		//echo 'halo';
		if (!is_array($listSujetPfe) || count($listSujetPfe) == 0 ) {
			//echo 'la list des sujet des pfe est vide';
			return null;
		}
		$listSujetMaster = listSujetMaster();
		if (!is_array($listSujetMaster) || count($listSujetMaster) == 0 ) {
			//echo 'la list des sujet des master est vide';
			return null;
		}
		$listFicheVoeux = listFicheVoeux();
		if (!is_array($listFicheVoeux) || count($listFicheVoeux) == 0 ) {
			//echo 'la fiche des veoux  est vide';
			return null;
		}

		$juryPfe = juryPfe($listFicheVoeux,$listSujetPfe,4);
		$juryMaster = juryMaster($listFicheVoeux,$listSujetMaster,4);
		foreach ($juryPfe as $key => $value) {
			$juryPfe[$key]=array_unique($value);
		}
		foreach ($juryMaster as $key => $value) {
			$juryMaster[$key]=array_unique($value);
		}
		return ['juryPfe'=>$juryPfe,'juryMaster'=>$juryMaster];
	}


	function juryPfe($listFicheVoeux,$listSujetPfe,$maxjury = 4){
		$juryPfe =array();

		while (1) {
			//echo '<br>'.count($listSujetPfe).'<br>';
			//echo '<br>'.count($juryPfe).'<br>';
			if (count($listSujetPfe)==0){
				break;
			}
			foreach ($listFicheVoeux as $i => $listFicheVoeu) {
				//var_dump($listFicheVoeu);
				$choixpfes = $listFicheVoeu['choixpfe'];
				$save = false;
				//echo 'fichevoeux<br>';
				//var_dump($choixpfes);

				foreach ($choixpfes as $j => $choixpfe) {
					// le premier jury
					//echo 'choipfes<br>';
					//var_dump($choixpfe);
					//die();
					if (!isset($juryPfe[$choixpfe['PFEID']])) {
						$juryPfe[$choixpfe['PFEID']][] = $listFicheVoeu['enseignantID'];
						$save = true;
						break;
						// le reste de jury
					} elseif (count($juryPfe[$choixpfe['PFEID']]) < $maxjury) {
						$juryPfe[$choixpfe['PFEID']][] = $listFicheVoeu['enseignantID'];

						suprimeColonne($listSujetPfe, 'PFEID',$choixpfe['PFEID']);
						$save = true;
						break;
					}
				}
				if (!$save) {
					// affectation aloeatoire
					//var_dump($listSujetPfe);
					foreach ($listSujetPfe as $j => $choixpfe){
						//echo 'save\n';
						//var_dump($choixpfe);
						$juryPfe[$choixpfe['PFEID']][] = $listFicheVoeu['enseignantID'];
						if (count($juryPfe[$choixpfe['PFEID']]) == $maxjury){
							suprimeColonne($listSujetPfe, 'PFEID', $choixpfe['PFEID']);
							break;
						}
					}
				}
			}
		}
		//var_dump($juryPfe);
		return $juryPfe;
	}
	function juryMaster($listFicheVoeux,$listSujetMaster,$maxjury = 4){
		$jury = [];
		while (1) {
			if (count($listSujetMaster)==0){
				break;
			}
			foreach ($listFicheVoeux as $i => $listFicheVoeu) {
				$choixMasters = $listFicheVoeu['choixmaster'];
				$save = false;
				foreach ($choixMasters as $j => $choixmaster) {
					// le premier jury
					if (!isset($jury[$choixmaster['masterID']])) {
						$jury[$choixmaster['masterID']][] = $listFicheVoeu['enseignantID'];
						$save = true;
						break;
						// le reste de jury
					} elseif (count($jury[$choixmaster['masterID']]) < $maxjury) {
						$jury[$choixmaster['masterID']][] = $listFicheVoeu['enseignantID'];
						suprimeColonne($listSujetMaster, 'masterID',$choixmaster['masterID']);
						$save = true;
						break;
					}
				}
				if (!$save) {
					// affectation aloeatoire
					foreach ($listSujetMaster as $j => $choixmaster){
						$jury[$choixmaster['masterID']][] = $listFicheVoeu['enseignantID'];
						if (count($jury[$choixmaster['masterID']]) == $maxjury){
							suprimeColonne($listSujetMaster, 'masterID', $choixmaster['masterID']);
							break;
						}
					}
				}
			}
		}
		return $jury;
	}
	function nbrEntreeJuryPfe($PFEID)
	{
		$bdd = connecterBDD();
		$req=$bdd->prepare('SELECT * FROM jurypfe WHERE PFEID=:PFEID');
		$req->execute(array('PFEID'=>$PFEID));
		$cpt=0;
		while($donnees=$req->fetch())
		{
			$cpt++;
		}

		$req->closeCursor();
		return $cpt;
	}

	function nbrEntreeJuryMaster($masterID)
	{
		$bdd = connecterBDD();
		$req=$bdd->prepare('SELECT * FROM jurymaster WHERE masterID=:masterID');
		$req->execute(array('masterID'=>$masterID));
		$cpt=0;
		while($donnees=$req->fetch())
		{
			$cpt++;
		}

		$req->closeCursor();
		return $cpt;
	}

	function extractUniqueKeysJuryPFE()
	{
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT * FROM jurypfe');
		$tab=array();
		$i=0;
		while ($donnees=$req->fetch())
		{
			$tab[$i]=$donnees['PFEID'];
			$i++;
		}
		$req->closeCursor();
		return array_unique($tab);
	}

	function extractUniqueKeysJuryMaster()
	{
		$bdd = connecterBDD();
		$req=$bdd->query('SELECT * FROM jurymaster');
		$tab=array();
		$i=0;
		while ($donnees=$req->fetch())
		{
			$tab[$i]=$donnees['masterID'];
			$i++;
		}
		$req->closeCursor();
		return array_unique($tab);
	}
