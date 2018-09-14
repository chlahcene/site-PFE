<?php
//$_SESSION['ficheVoeuxID']=1;
//$_SESSION['Valide']=0;
//$_SESSION['enseignantID']=1;
?>

<!DOCTYPE html>
<html>
<head>


    <?php
        require __DIR__.'/../../php/_links.php' ?>
	<title>Voeux saisis</title>
</head>
<body>
    <?php require(__DIR__.'/../../php/_Navbar.php'); ?>
    <div class="jumbotron" style="text-align: center;background-color: white"> 
      <h1 class="display-4" >Mon Formulaire</h1>
      <h6 class="display-6">Afficher ou modifier vos voeux</h6> 
      <hr class="my-4">
    <br>
    <br>



<?php $mnt=new DateTime(date('Y-m-d h:i:s')); 
  if ($_SESSION['date_debut']==null) 
    { 
      ?><p>saisie des voeux indisponible pour le moment. Veuillez attendre le lancement de la procédure.</p> <?php  
    } 
  else if($_SESSION['date_debut']>$mnt) 
        { 
          ?><p>Formulaire indisponible pour le moment. Date de début de procédure: 
          <?php echo ' '.$_SESSION['date_debut']->format('Y-m-d h:i:s'); ?></p> <?php 
        } 
  else if($_SESSION['date_fin']!=null && $_SESSION['date_fin']<$mnt)
         { 
           ?> <p>Procédure terminée le: 
           <?php echo ' '.$_SESSION['date_fin']->format('Y-m-d h:i:s'); ?></p> <?php 
         } 
  if ($_SESSION['Valide']==1) { ?><p>liste de vos choix validés</p><?php }
  else if ($_SESSION['Valide']==0 && $_SESSION['ficheVoeuxID']!=0) { ?><p>liste de vos choix sauvegardés</p><?php }
     ?>


	<form method="post" action="/nouveau_form"  >
  			<table style="background-color: white" class="table table-bordered" >
        <tr>
            <thead >
  				<th style="text-align: center;"> </th>
  				<th style="text-align: center;">SIT</th>
  				<th style="text-align: center;">SIQ</th>
  				<th style="text-align: center;">SIL</th>
  				<th style="text-align: center;">Mixte</th>
  				<th style="text-align: center;">Master</th>
      </thead>
  			</tr>
            <?php require(__DIR__.'/../../php/fonctions.php'); ?>
            <?php for($i=1;$i<=10;$i++) { ?>
            <tr>
               	<th>Choix<?php echo $i; ?></th>
            
               	<?php echo '<td style="width: 300px">'.get_choix_by_spec('SIT',$i,$_SESSION['ficheVoeuxID']).' '.get_titre_by_spec('SIT',$i,$_SESSION['ficheVoeuxID']).' </td>'; ?>

                <?php echo '<td style="width: 300px">'.get_choix_by_spec('SIQ',$i,$_SESSION['ficheVoeuxID']).' '.get_titre_by_spec('SIQ',$i,$_SESSION['ficheVoeuxID']).' </td>'; ?>

                <?php echo '<td style="width: 300px">'.get_choix_by_spec('SIL',$i,$_SESSION['ficheVoeuxID']).' '.get_titre_by_spec('SIL',$i,$_SESSION['ficheVoeuxID']).' </td>'; ?>

                <?php echo '<td style="width: 300px">'.get_choix_by_spec('MIXTE',$i,$_SESSION['ficheVoeuxID']).' '.get_titre_by_spec('MIXTE',$i,$_SESSION['ficheVoeuxID']).' </td>'; ?> 

              <?php echo '<td style="width: 300px">'.get_choix_by_spec('MASTER',$i,$_SESSION['ficheVoeuxID']).' '.get_titre_by_spec('MASTER',$i,$_SESSION['ficheVoeuxID']).' </td>'; ?>  
               	 
            </tr>     
            <?php } ?>

			</table>
        <?php 
              if ($mnt >= $_SESSION['date_debut'] && $mnt < $_SESSION['date_fin'] && $_SESSION['Valide']==0) { ?> 
                  <button type="submit" name="modifier" value="modifier" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Modifier</a> </button> <?php } 
        ?>
			<!--<input id="modifier" type="submit" name="modifier" value="modifier">-->
</form>
</div>
<br>
<br>
</div>
</body>
<?php require(__DIR__.'/../../php/_footer.php') ?>
<!--/.Footer-->
  <?php require(__DIR__.'/../../php/_Scripts_home.php') ?>
</html>