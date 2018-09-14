<?php

	require("php/fonctions.php");
	$bdd = connecterBDD();
    if (!login($_POST['login'],$_POST['password'])) //si authentification==faux:
    {
    	if ($_SESSION['login']==null)
    	{
    		header('Location: /login?err=adresse email incorrect');
    	}
    	else if ($_SESSION['mdp']==null)
    	{   
    		header('Location: /login?err=mot de passe incorrect');
    	}
    }
    else
    {
    $_SESSION['login']=$_POST['login'];

    //recuperer le compteID et le type de profil:
	$req = $bdd->prepare('SELECT Type, compteID FROM compte WHERE login= ?'); 
	$req->execute(array($_POST['login']));
	$donnee=$req->fetch();
	$req->closeCursor();

	$_SESSION['type']=$donnee['Type'];
	$_SESSION['compteID']=$donnee['compteID'];

	//recuperer les dates des procédures
	$req=$bdd->query('SELECT dat, heure FROM notifctrl');
    $donnee=$req->fetch();
    if ($donnee['dat']!=null) $_SESSION['date_debut']=new DateTime($donnee['dat'].' '.$donnee['heure']); 
    else {$_SESSION['date_debut']=null;}

    $donnee=$req->fetch();
    if ($donnee['dat']!=null) $_SESSION['date_rappel']=new DateTime($donnee['dat'].' '.$donnee['heure']); 
    else {$_SESSION['date_rappel']=null;}

    $donnee=$req->fetch();
    if ($donnee['dat']!=null) $_SESSION['date_fin']=new DateTime($donnee['dat'].' '.$donnee['heure']); 
    else {$_SESSION['date_fin']=null;}

    $req->closeCursor();
    
    //recuperer les données selon le type de profil
	if ($_SESSION['type']=='enseignant' || $_SESSION['type']=='responsable') 
	{
		$req = $bdd->prepare('SELECT NomEnseignant, PrenomEnseignant, enseignantID, derniere_connexion FROM enseignant WHERE compteID=?'); 
	    $req->execute(array($_SESSION['compteID']));
	    $donnee=$req->fetch();
	    $req->closeCursor();

	    $_SESSION['nom']=$donnee['NomEnseignant'];
	    $_SESSION['prenom']=$donnee['PrenomEnseignant'];
	    $_SESSION['enseignantID']=$donnee['enseignantID']; 
	    $_SESSION['nbrNotifs']=calculNbNotifs($_SESSION['enseignantID']);
	    if ($donnee['derniere_connexion']==null) $_SESSION['derniere_connexion']=date('01-01-2000 00:00:00');
	    else $_SESSION['derniere_connexion']=$donnee['derniere_connexion'];


	    $req = $bdd->prepare('SELECT ficheVoeuxID, Valide FROM fichevoeux WHERE enseignantID=?');
	    $req->execute(array($_SESSION['enseignantID']));
	    if ($donnee=$req->fetch())
	    {
	    	$_SESSION['ficheVoeuxID']=$donnee['ficheVoeuxID'];
	    	$_SESSION['Valide']=$donnee['Valide'];
	    }
	    else
	    {
	    	$_SESSION['ficheVoeuxID']=0;
	    	$_SESSION['Valide']=0;
	    }
	    $req->closeCursor();
	}
	else
	{
		$req = $bdd->prepare('SELECT NomEmploye, PrenomEmploye, employeID FROM employe WHERE compteID=?');
	    $req->execute(array($_SESSION['compteID']));
	    $donnee=$req->fetch();
	    $req->closeCursor();

	    $_SESSION['nom']=$donnee['NomEmploye'];
	    $_SESSION['prenom']=$donnee['PrenomEmploye'];
	    $_SESSION['employeID']=$donnee['employeID'];
	}
    header("Location: /");
}

?>