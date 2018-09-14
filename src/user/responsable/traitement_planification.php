<?php


 if (isset($_POST['Enregistrer']) && isset($_POST['choix']) && $_POST['contenu']!='' && isset($_POST['date']) && isset($_POST['time']))
 {
	 require (__DIR__.'/../../php/bdd.php');
	 $bdd = connecterBDD();
   $date=$_POST['date'];
   $time=$_POST['time'];
   $contenu=$_POST['contenu'];

   //traitement de chaque choix:
   if ($_POST['choix']=='debut')
   {
      $req=$bdd->prepare('UPDATE notifctrl SET contenu=:contenu, dat=:dat, heure=:heure WHERE objet= \'Début de procédure\'');
      $req->execute(array('contenu'=>$_POST['contenu'], 'dat'=>$date, 'heure'=>$time));
      $req->closeCursor();

      $_SESSION['date_debut']=new DateTime($date.' '.$time);
       
   }
  
  else if ($_POST['choix']=='rappel')
  {
      $req=$bdd->prepare('UPDATE notifctrl SET contenu=:contenu, dat=:dat, heure=:heure WHERE objet= \'Rappel\'');
      $req->execute(array('contenu'=>$_POST['contenu'], 'dat'=>$date, 'heure'=>$time));
      $req->closeCursor();

      $_SESSION['date_rappel']=new DateTime($date.' '.$time);
  }

  else if ($_POST['choix']=='fin')
  {
    $req=$bdd->prepare('UPDATE notifctrl SET contenu=:contenu, dat=:dat, heure=:heure WHERE objet= \'Fin de procédure\'');
      $req->execute(array('contenu'=>$_POST['contenu'], 'dat'=>$date, 'heure'=>$time));
      $req->closeCursor();

      $_SESSION['date_fin']=new DateTime($date.' '.$time);
  }

  header('Location: /Calendrier');
}

else 
{
   header('Location: /Planification?err="incomplet');
}

?>