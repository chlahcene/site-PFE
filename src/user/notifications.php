

<!DOCTYPE html>
<html>
<head>
    <title>Notification</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/boostrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
  <?php require ( __DIR__.'/../php/_links.php'); ?>
</head>
<body>
	<?php require ( __DIR__.'/../php/_Navbar.php'); ?>
    <br>
    <br>
    <br>
    <div class="container">
	<?php
    //echo 'halooooooooooo';
		require ( __DIR__.'/../php/fonctions.php'); 
		$bdd = connecterBDD();
       //récupérer les dates des notifications:
       $req=$bdd->query('SELECT objet, dat, heure, contenu FROM notifctrl');
       $cpt=0;
       
       while ($donnee=$req->fetch())
       {   
         if ($donnee['dat']!=null)
          {  
            $date_notif=new DateTime($donnee['dat'].' '.$donnee['heure']);
            
            if ($date_notif>new DateTime($_SESSION['derniere_connexion']) && new DateTime(date("Y-m-d H:i:s"))>=$date_notif && ($donnee['objet']=='Début de procédure' || $donnee['objet']=='Fin de procédure')) 
            //date d'envoi de notif entre date actuelle et date de derniere connexion
             {    $cpt++;
               
                  ?><div class="alert alert-info alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Info!</strong><?php echo ' '.$date_notif->format('Y-m-d h:i:s').' :'.$donnee['contenu']; ?>
                    </div><?php
             }

            else if (isRetardataire($_SESSION['enseignantID']) && $donnee['objet']=='Rappel')
               { $cpt++;
               	 ?><div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Rappel!</strong><?php echo ' '.$date_notif->format('Y-m-d h:i:s').' :'.$donnee['contenu']; ?>
                    </div><?php 
               }
             
          }
       }
       if ($cpt==0) { ?><p style="text-align: center;">AUCUNE NOTIFICATION</p><?php } 

       $req->closeCursor();
       $_SESSION['nbrNotifs']=0;
	 

if ($_SESSION['type']=='responsable') {  ?>
    <hr class="my-4">
    <h3 style="text-align:center">Envoyer un message instantanné</h3><br>
    <form action="/Notifications_check" method="post">
       <select class="selectpicker" data-show-subtext="true" data-live-search="true" id="destinataire" name="ens">
       <?php
       $req=$bdd->query('SELECT EmailEnseignant, NomEnseignant, PrenomEnseignant FROM enseignant');
       while($donnees=$req->fetch())
         {
           echo '<option value="'.$donnees['EmailEnseignant'].'">'.$donnees['NomEnseignant'].' '.$donnees['PrenomEnseignant'].'</option>';
         }

         ?>

       </select>
       <br><br>


        <div class="col-md-4">
            <input class="form-control col-md-8" type="text" name="objet" placeholder="objet" required="required">

            <textarea  id="two" class="form-control col-md-14" name="contenu" COLS="30" ROWS="3" placeholder="Votre notification ici"></textarea>
            <br>
            <button type="submit" name="Envoyer" value="Envoyer" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Confirmer</a> </button>

            <br><br>
        </div>

        <br><br>
     </form>
         
      <?php 
      if (isset($_GET['etat']) && $_GET['etat']=='success') { ?><script>alert('Message transmis avec succés!');</script><?php } 
      if (isset($_GET['etat']) && $_GET['etat']=='fail') { ?><script>alert('Veuillez définir le contenu du message');</script><?php } 

        }   ?>
	
 </div>
    <br>
    <br>
    <br>
 <?php require ( __DIR__.'/../php/_footer.php'); ?>
<!--/.Footer-->
  <?php require ( __DIR__.'/../php/_Scripts_home.php'); ?>
</body>

</html>