

<!DOCTYPE html>
<html>
<head>
    <title>Affectations</title>
  <?php require ( __DIR__.'/../../php/_links.php') ?>
  
</head>
<body>
<?php require ( __DIR__.'/../../php/_Navbar.php') ?>
<br>
<br>
<h1 class="display-4" style="text-align: center">Affectations</h1>
<h6 class="display-6" style="text-align: center">Visualiser les propositions d'affectation</h6> 
<hr class="my-4">
<?php require ( __DIR__.'/../../php/fonctions.php'); ?>
<!--/.Footer-->
<div class="container-fluid bg align-center" >
    <div class="row">
        
        <?php
            $prop = propositionTemp();
            if ($prop!=null){
                   insertJuryMasters($prop['juryMaster']);
                insertJuryPfes($prop['juryPfe']);
        ?>
        <h2>PFE</h2>
        <table class="table">
            <?php
				$bdd = connecterBDD();
               $tab=extractUniqueKeysJuryPFE();
               foreach ($tab as $key=>$PFEID)
               { 
                  $req=$bdd->prepare('SELECT * FROM jurypfe WHERE PFEID=? ORDER BY PFEID');
                  $req->execute(array($PFEID));
                  echo '<tr>';
                  echo '<td rowspan="'.nbrEntreeJuryPfe($PFEID).'" style="border : 1px solid black;width: 200px;">'.PFEID_to_code($PFEID).': '.PFEID_to_titre($PFEID).'</td>';
                  $cpt=0;
                  while($donnee=$req->fetch())
                  {
                    if ($cpt==1) echo '<tr>';
                    echo '<td style="border : 1px solid black; width:200px;">'.getNomPrenomEnsByID($donnee['enseignantID']).'</td>';
                    echo '</tr>';
                    $cpt=1;
                  }
                  $req->closeCursor(); 
               }
            ?>
        </table>
         <h2 align: center>Master</h2>
        <table style="border-collapse: collapse;">
        <?php  

               $tab2=extractUniqueKeysJuryMaster();

               foreach ($tab2 as $key=>$masterID)
               { 
                  $req=$bdd->prepare('SELECT * FROM jurymaster WHERE masterID=? ORDER BY masterID');
                  $req->execute(array($masterID));
                  echo '<tr>';
                  echo '<td rowspan="'.nbrEntreeJuryMaster($masterID).'" style="border : 1px solid black;width: 200px;">'.masterID_to_code($masterID).': '.masterID_to_titre($masterID).'</td>';
                  $cpt=0;
                  while($donnee=$req->fetch())
                  {
                    if ($cpt==1) echo '<tr>';
                    echo '<td style="border : 1px solid black;width: 200px;">'.getNomPrenomEnsByID($donnee['enseignantID']).'</td>';
                    echo '</tr>';
                    $cpt=1;
                  }
                  $req->closeCursor(); 
               }
        ?>
      </table><?php } 
      else { ?><p style="margin :0 auto">Aucune proposition d'affectation disponible pour le moment. Veuillez attendre que les enseignants valident leurs fiche de voeux</p><?php  } ?>
    </div>
</div>
<!--Footer-->
<br>
<br>
<?php require ( __DIR__.'/../../php/_footer.php') ?>

<?php require ( __DIR__.'/../../php/_Scripts_home.php') ?>

</body>
</html>