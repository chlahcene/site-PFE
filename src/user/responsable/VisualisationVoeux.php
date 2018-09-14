<?php ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/boostrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <?php  require ( __DIR__.'/../../php/_links.php'); ?>
</head>
<body>
  <?php require ( __DIR__.'/../../php/_Navbar.php'); ?>
  	<h1 class="display-4" style="text-align: center">Voeux des enseignants</h1>
    <h6 class="display-6" style="text-align: center">Visualiser les voeux des enseignants ayant valider leur fiche</h6> 

  	<hr class="my-4">
   <?php
	   require ( __DIR__.'/../../php/fonctions.php');$bdd = connecterBDD();
          $req=$bdd->query('SELECT * FROM fichevoeux WHERE Valide=1'); ?>
          <form method="post" action="/VisualisationVoeux">

              <select class="selectpicker col-md-4" data-show-subtext="true" data-live-search="true" name="ensList">
              <option value="rien">Selectionnez un enseignant</option>
   	          <?php 
   	              while ($donnees=$req->fetch())
   	                  {
   	  	                ?><option value=<?php echo $donnees['ficheVoeuxID']; ?>><?php echo getNomPrenomEnsByID($donnees['enseignantID']); ?></option><?php
   	                  }
   	              $req->closeCursor(); ?>
              </select><br><br>
              <button type="submit" name="confirmer" value="confirmer" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Confirmer</a> </button>
          
           </form>
       <br><br>

<?php //*************************************************************************************************************************************

if (isset($_POST['confirmer']) && $_POST['ensList']!='rien') { ?>
        <p style="text-align:center";>Voeux de:  <?php echo getNomPrenomEnsByficheVoeuxID($_POST['ensList']) ?></p>
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
            <?php for($i=1;$i<=10;$i++) { ?>
            <tr>
               	<th>Choix<?php echo $i; ?></th>
            
               	<?php echo '<td style="width: 300px">'.get_choix_by_spec('SIT',$i,$_POST['ensList']).' '.get_titre_by_spec('SIT',$i,$_POST['ensList']).' </td>'; ?>

                <?php echo '<td style="width: 300px">'.get_choix_by_spec('SIQ',$i,$_POST['ensList']).' '.get_titre_by_spec('SIQ',$i,$_POST['ensList']).' </td>'; ?>

                <?php echo '<td style="width: 300px">'.get_choix_by_spec('SIL',$i,$_POST['ensList']).' '.get_titre_by_spec('SIL',$i,$_POST['ensList']).' </td>'; ?>

                <?php echo '<td style="width: 300px">'.get_choix_by_spec('MIXTE',$i,$_POST['ensList']).' '.get_titre_by_spec('MIXTE',$i,$_POST['ensList']).' </td>'; ?> 

              <?php echo '<td style="width: 300px">'.get_choix_by_spec('MASTER',$i,$_POST['ensList']).' '.get_titre_by_spec('MASTER',$i,$_POST['ensList']).' </td>'; ?>  
               	 
            </tr>     
            <?php } ?>

			</table>

<?php } ?>
</body>
<?php require ( __DIR__.'/../../php/_footer.php') ?>
<script type="text/javascript">
    var urlmenu = document.getElementById( 'menu1' );
    urlmenu.onchange = function() {
        window.open( this.options[ this.selectedIndex ].value );
                    };
    </script>
   
<?php require ( __DIR__.'/../../php/_Scripts_home.php') ?>

</html>