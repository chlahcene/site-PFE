<?php 
//$_SESSION['ficheVoeuxID']=1;
//$_SESSION['Valide']=0;
//$_SESSION['enseignantID']=1;
//
 ?>

<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" href="css/boostrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-select.min.css">
      <?php require __DIR__.'/../../php/_links.php'; ?>
      <?php require __DIR__.'/../../php/fonctions.php'; ?>

  <title>fiche de voeux</title>
</head>
<body>

      <?php require __DIR__.'/../../php/_Navbar.php' ?>


  <?php
  $bdd = connecterBDD();
  ?>
  <div class="jumbotron" style="text-align: center;background-color: white">
  <h1 class="display-4" >FICHE DE VOEUX</h1>
  <h6 class="display-6" style="text-align: center">Sauvegarder ou valider vos voeux par ordre de préférence</h6> 
  
  <form method="post" action="/formulaire_check" onsubmit="return confirm('Confirmez-vous sur l\'envoi du formulaire?');">
      <br>
      <table class="table">
        <tr>
          <td class="signe_plus"><acronym title="ajouter choix SIT"><input class="btn" style="background-color: #088A85;border: none;" id="plus_SIT" type="button" value="+" onclick="addSIT();enableOrNot();"></acronym></td>
          <td class="signe_plus"><acronym title="ajouter choix SIQ"><input class="btn" style="background-color: #088A85;border: none;" id="plus_SIQ" type="button" value="+" onclick="addSIQ();enableOrNot();"></acronym></td>
          <td class="signe_plus"><acronym title="ajouter choix SIL"><input class="btn" style="background-color: #088A85;border: none;" id="plus_SIL" type="button" value="+" onclick="addSIL();enableOrNot();"></acronym></td>
          <td class="signe_plus"><acronym title="ajouter choix MIXTE"><input class="btn" style="background-color: #088A85;border: none;" id="plus_MIXTE" type="button" value="+" onclick="addMIXTE();enableOrNot();"></acronym></td>
          <td class="signe_plus"><acronym title="ajouter choix MASTER"><input class="btn" style="background-color: #088A85;border: none;" id="plus_MASTER" type="button" value="+" onclick="addMASTER();enableOrNot();"></acronym></td>
        </tr>
        <tr>
          <th style="text-align:center">SIT</th>
          <th style="text-align:center">SIQ</th>
          <th style="text-align:center">SIL</th>
          <th style="text-align:center">Mixte</th>
          <th style="text-align:center">Master</th>
        </tr>

        
                <?php for($i=1;$i<=10;$i++) { ?> <!--générer 10 lignes du tableau de formulaire-->

        <tr>

          <td <?php echo 'id="SITcell'.$i.'"'; ?> style="visibility: hidden"> <!--recuperer les choix SIT possibles de la bdd--> 
            <div class="row-fluid" >
            <select style="width:100px" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="enableOrNot();" name="choix_SIT[]" id=<?php echo 'choix_SIT'.$i; ?>>
              <?php $choix=get_choix_by_spec('SIT',$i,$_SESSION['ficheVoeuxID']); $exist=false; ?>
              <?php $reponse = $bdd->query('SELECT CodePFE, TitrePFE FROM pfe WHERE SpecialitePFE=\'SIT\''); ?>
                <?php while ($donnees = $reponse->fetch()) { ?>   
          
                   <option value=<?php echo $donnees['CodePFE']; ?> <?php if($donnees['CodePFE']==$choix) 
                   {echo ' selected="selected"'; 
                   $exist=true;
                   
                    } ?>>            <?php echo $donnees['CodePFE'].' : '.$donnees['TitrePFE']; ?></option>
              <?php } $reponse->closeCursor(); ?>
            </select>
          </div>
          </td>

          <td <?php echo 'id="SIQcell'.$i.'"'; ?> style="visibility: hidden">
            <select style="width:100px" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="enableOrNot();" name="choix_SIQ[]" id=<?php echo 'choix_SIQ'.$i; ?>>
              <?php $choix=get_choix_by_spec('SIQ',$i,$_SESSION['ficheVoeuxID']); $exist=false; ?>
              <?php $reponse = $bdd->query('SELECT CodePFE, TitrePFE FROM pfe WHERE SpecialitePFE=\'SIQ\''); ?>
                <?php while ($donnees = $reponse->fetch()) { ?>   
          
                   <option value=<?php echo $donnees['CodePFE']; ?> <?php if($donnees['CodePFE']==$choix) {echo ' selected="selected"'; $exist=true;} ?>>            <?php echo $donnees['CodePFE'].' : '.$donnees['TitrePFE']; ?></option>
              <?php } $reponse->closeCursor(); ?>
            </select>
          </td>

          <td <?php echo 'id="SILcell'.$i.'"'; ?> style="visibility: hidden">
            <select style="width:100px" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="enableOrNot();" name="choix_SIL[]" id=<?php echo 'choix_SIL'.$i; ?>>
              <?php $choix=get_choix_by_spec('SIL',$i,$_SESSION['ficheVoeuxID']); $exist=false; ?>
              <?php $reponse = $bdd->query('SELECT CodePFE, TitrePFE FROM pfe WHERE SpecialitePFE=\'SIL\''); ?>
                <?php while ($donnees = $reponse->fetch()) { ?>   
          
                   <option value=<?php echo $donnees['CodePFE']; ?> <?php if($donnees['CodePFE']==$choix) {echo ' selected="selected" '; $exist=true;} ?>>              <?php echo $donnees['CodePFE'].' : '.$donnees['TitrePFE']; ?></option>
              <?php } $reponse->closeCursor(); ?>
            </select>
          </td>

          <td <?php echo 'id="MIXTEcell'.$i.'"'; ?> style="visibility: hidden">
            <select style="width:100px" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="enableOrNot();" name="choix_MXT[]" id=<?php echo 'choix_MXT'.$i; ?>>
              <?php $choix=get_choix_by_spec('MIXTE',$i,$_SESSION['ficheVoeuxID']); $exist=false; ?>
              <?php $reponse = $bdd->query('SELECT CodePFE, TitrePFE FROM pfe WHERE SpecialitePFE=\'MIXTE\''); ?>
                <?php while ($donnees = $reponse->fetch()) { ?>   
          
                   <option value=<?php echo $donnees['CodePFE']; ?> <?php if($donnees['CodePFE']==$choix) {echo ' selected="selected"'; $exist=true;} ?>>            <?php echo $donnees['CodePFE'].' : '.$donnees['TitrePFE']; ?></option>
              <?php } $reponse->closeCursor(); ?>
            </select>
          </td>

          <td <?php echo 'id="MASTERcell'.$i.'"'; ?> style="visibility: hidden">
            <select style="width:100px" class="selectpicker" data-show-subtext="true" data-live-search="true" onchange="enableOrNot();" name="choix_MASTER[]" id=<?php echo 'choix_MASTER'.$i; ?>>
              <?php $choix=get_choix_by_spec('MASTER',$i,$_SESSION['ficheVoeuxID']); $exist=false; ?>
              <optgroup label="SIT">
                <?php $reponse = $bdd->query('SELECT CodeMaster, TitreMaster FROM master WHERE SpecialiteMaster=\'SIT\''); 
                      while ($donnees = $reponse->fetch()) {  ?>
                      <option value=<?php echo $donnees['CodeMaster']; ?> <?php if ($donnees['CodeMaster']==$choix) {echo ' selected="selected"'; $exist=true;} ?>><?php echo $donnees['CodeMaster'].' : '.$donnees['TitreMaster']; ?></option>
                      <?php 
                      }
                      $reponse->closeCursor(); ?>
              </optgroup>

              <optgroup label="SIQ">
                <?php $reponse = $bdd->query('SELECT CodeMaster, TitreMaster FROM master WHERE SpecialiteMaster=\'SIQ\''); 
                      while ($donnees = $reponse->fetch()) {  ?>
                      <option value=<?php echo $donnees['CodeMaster']; ?> <?php if ($donnees['CodeMaster']==$choix) {echo ' selected="selected"'; $exist=true;} ?>><?php echo $donnees['CodeMaster'].' : '.$donnees['TitreMaster']; ?></option> 
                      <?php 
                      }
                      $reponse->closeCursor(); ?>
              </optgroup>

              <optgroup label="SIL">
                <?php $reponse = $bdd->query('SELECT CodeMaster, TitreMaster FROM master WHERE SpecialiteMaster=\'SIL\''); 
                      while ($donnees = $reponse->fetch()) {  ?>
                      <option value=<?php echo $donnees['CodeMaster']; ?> <?php if ($donnees['CodeMaster']==$choix) {echo ' selected="selected"'; $exist=true;} ?>><?php echo $donnees['CodeMaster'].' : '.$donnees['TitreMaster']; ?></option>
                      <?php 
                      }
                      $reponse->closeCursor(); ?>
              </optgroup>

              <optgroup label="MIXTE">
                <?php $reponse = $bdd->query('SELECT CodeMaster, TitreMaster FROM master WHERE SpecialiteMaster=\'MIXTE\''); 
                      while ($donnees = $reponse->fetch()) {  ?>
                      <option value=<?php echo $donnees['CodeMaster']; ?> <?php if ($donnees['CodeMaster']==$choix) {echo ' selected="selected"'; $exist=true;} ?>><?php echo $donnees['CodeMaster'].' : '.$donnees['TitreMaster']; ?></option>
                      <?php 
                      }
                      $reponse->closeCursor(); ?>
              </optgroup>
            </select>
          </td>
        </tr>
        <?php } ?>
    
        <tr>
          <td class="signe_moins" id="moins_SIT"><acronym title="supprimer choix SIT"><input class="btn" style="background-color: #088A85;border: none;" type="button" value="-" onclick="subSIT();enableOrNot();"></acronym></td>
          <td class="signe_moins" id="moins_SIQ"><acronym title="supprimer choix SIQ"><input class="btn" style="background-color: #088A85;border: none;" type="button" value="-" onclick="subSIQ();enableOrNot();"></acronym></td>
          <td class="signe_moins" id="moins_SIL"><acronym title="supprimer choix SIL"><input class="btn" style="background-color: #088A85;border: none;" type="button" value="-" onclick="subSIL();enableOrNot();"></acronym></td>
          <td class="signe_moins" id="moins_MIXTE"><acronym title="supprimer choix MIXTE"><input class="btn" style="background-color: #088A85;border: none;" type="button" value="-" onclick="subMIXTE();enableOrNot();"></acronym></td>
          <td class="signe_moins" id="moins_MASTER"><acronym title="supprimer choix MASTER"><input class="btn" style="background-color: #088A85;border: none;" type="button" value="-" onclick="subMASTER();enableOrNot();"></acronym></td>
        </tr>
        
      </table>

      <input type="hidden" name="taiSIT" value="0" id="taiSIT">
      <input  type="hidden" name="taiSIQ" value="0" id="taiSIQ">
      <input  type="hidden" name="taiSIL" value="0" id="taiSIL">
      <input  type="hidden" name="taiMIXTE" value="0" id="taiMIXTE">
      <input  type="hidden" name="taiMASTER" value="0" id="taiMASTER">
      <br>
      <div class="submit">
  <button type="submit" name="sauvegarder" value="sauvegarder" id="sauvegarder" class="btn btn-lg" style="background-color: #088A85;border: none;" disabled=""> <a style="text-decoration: none;color: white" >sauvegarder</a> </button>
                     <button type="submit" name="valider" value="valider" id="valider" class="btn btn-lg" style="background-color: #088A85;border: none;" disabled=""> <a style="text-decoration: none;color: white" >valider</a> </button>
      </div>
      <br>
      <p><strong>NB1: un choix suffit pour sauvgarder le formulaire.</strong></p>
      <p><strong>NB2: vous devez effectuer au moins 3 choix différents dans chaque spécialité (2 choix pour Master) pour valider le formulaire.</strong></p><br>
    </div>
  </form>
</div>

</body>

  <script type="text/javascript" src="../../../public/js/scriptForm.js"></script>
  <script src="../../../public/js/jquery.min.js"></script>
  <script src="../../../public/js/boostrap.min.js"></script>
  <script src="../../../public/js/bootstrap-select.min.js"></script>


<?php require __DIR__.'/../../php/_footer.php' ?>
<!--/.Footer-->
  <?php require __DIR__.'/../../php/_Scripts_home.php'; ?>
</html>