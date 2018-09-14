

<!DOCTYPE html>
<html>
<head>
	<title>Statistiques</title>
  <?php require( __DIR__.'/'.'../../php/_links.php') ; ?>

</head>

<body>
<?php require( __DIR__.'/'.'../../php/_Navbar.php'); ?>


  <div class="jumbotron" style="text-align: center;background-color: white">
  <h1 class="display-4" >Statistiques</h1>
  <h6 class="display-6" style="text-align: center">Visualiser des statistiques concernant les différentes spécialités</h6> 
  <hr class="my-4">
	<form action="/Statistiques" method="post">
        <div id="stat_form">
            <table>
                <tr>
                    <th>
                        <label for="critere">Critère</label>
                    </th>
                    <td>
                        <select id="critere" class="form-control col-md-4 col-lg-6 col-ms-12" name="critere" style="">
                            <option></option>
                            <option value="plus_choisis">10 sujets les plus choisis</option>
                            <option value="moins_choisis">10 sujets les moins choisis</option>
                            <option value="non_choisis">les sujets non choisis</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>
                        <label for="specialite">Spécialité</label>
                    </th>
                    <td>
                        <select id="specialite" class="selectpicker form-control col-md-4 col-lg-6 col-ms-12" name="specialite" style="">
                            <option></option>
                            <option value="PFE">PFE (tous)</option>
                            <option value="SIT">SIT (pfe)</option>
                            <option value="SIQ">SIQ (pfe)</option>
                            <option value="SIL">SIL (pfe)</option>
                            <option value="MIXTE">MIXTE (pfe)</option>
                            <option value="MASTER">Master (tous)</option>
                            <option value="MSIT">SIT (master)</option>
                            <option value="MSIQ">SIQ (master)</option>
                            <option value="MSIL">SIL (master)</option>
                            <option value="MMXT">MIXTE (master)</option>
                        </select>
                    </td>
            </table>
            <br>
            <button type="submit" name="confirmer" value="confirmer" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white">Confirmer</a> </button>

        </div>
  </form>
  <br><br>


<?php
 if (isset($_POST['confirmer']))
 {

     $specialite=$_POST['specialite'];
     $critere=$_POST['critere'];
    
     $cpt=1;
	require( __DIR__.'/'.'../../php/bdd.php');
	$bdd = connecterBDD();
     if ($specialite=='PFE' || $specialite=='SIT' || $specialite=='SIQ' || $specialite=='SIL' || $specialite=='MIXTE')
       {
         if ($specialite=='PFE')
            {
             if ($critere=='plus_choisis') $req = $bdd->query('SELECT CodePFE, TitrePFE, chemin, NbChoix FROM pfe WHERE NbChoix>0 ORDER BY NbChoix DESC LIMIT 0,10');
             else if($critere=='moins_choisis') $req = $bdd->query('SELECT CodePFE, TitrePFE, chemin, NbChoix FROM pfe WHERE NbChoix>0 ORDER BY NbChoix LIMIT 0,10');
             else if ($critere=='non_choisis') $req = $bdd->query('SELECT CodePFE, TitrePFE, chemin FROM pfe WHERE NbChoix=0');
            }

         else if ($specialite=='SIT' || $specialite=='SIQ' || $specialite=='SIL' || $specialite=='MIXTE')
            {

             if ($critere=='plus_choisis') $req = $bdd->prepare('SELECT CodePFE, TitrePFE, chemin, NbChoix FROM pfe WHERE SpecialitePFE=? AND NbChoix>0 ORDER BY NbChoix DESC LIMIT 0,10');
             else if($critere=='moins_choisis') $req = $bdd->prepare('SELECT CodePFE, TitrePFE, chemin, NbChoix FROM pfe WHERE SpecialitePFE=? AND NbChoix>0 ORDER BY NbChoix LIMIT 0,10');
             else if ($critere=='non_choisis') $req = $bdd->prepare('SELECT CodePFE, TitrePFE, chemin FROM pfe WHERE SpecialitePFE=? AND NbChoix=0');
             $req->execute(array($specialite));
            } ?>
         <table>
         <?php while ($donnees=$req->fetch()) { 
         if ($cpt==1) 
           { 
            echo '<p style="text-align:left"> Spécialité: '.$specialite.'</p> '; 
            if ($critere=='non_choisis') echo '<p style="text-align:left"> critère de recherche: les sujets non choisis</p>';
            else if ($critere=='plus_choisis') echo '<p style="text-align:left"> critère de recherche: les 10 sujets les plus choisis</p>';
            else if ($critere=='moins_choisis') echo '<p style="text-align:left"> critère de recherche: les 10 sujets les moins choisis</p>';?>
             <tr>
                <th>Code PFE</th>
                <th>Titre PFE</th>
            <?php if ($critere!='non_choisis') {?> <th>Nombre de choix</th><?php } ?>
                <th>Lien de visualisation</th>
              </tr> <?php }
             
              echo '<tr>';
              echo '<td>'.$donnees['CodePFE'].'</td>';
              echo '<td id="titre">'.$donnees['TitrePFE'].'</td>';
              if ($critere!='non_choisis') echo '<td>'.$donnees['NbChoix'].'</td>';
              echo '<td><a href='.$donnees['chemin'].' target="_blank"> visualiser la fiche descriptive </a></td>';
              echo '</tr>';
              $cpt=2;
             }
             echo '</table>';
             $req->closeCursor();
        }
 
     else if ($specialite=='MASTER' || $specialite=='MSIT' || $specialite=='MSIQ' || $specialite=='MSIL' || $specialite=='MMXT')
      {
         if ($specialite=='MASTER')
         {
          if ($critere=='plus_choisis') $req = $bdd->query('SELECT CodeMaster, TitreMaster, chemin, NbChoix FROM master WHERE NbChoix>0 ORDER BY NbChoix DESC LIMIT 0,10');
          else if($critere=='moins_choisis') $req = $bdd->query('SELECT CodeMaster, TitreMaster, chemin, NbChoix FROM master WHERE NbChoix>0 ORDER BY NbChoix LIMIT 0,10');
          else if ($critere=='non_choisis') $req = $bdd->query('SELECT CodeMaster, TitreMaster, chemin FROM master WHERE NbChoix=0');
         }
         else if ($specialite=='MSIT' || $specialite=='MSIQ' || $specialite=='MSIL' || $specialite=='MMXT')
         {
           if ($specialite=='MSIT') $specialite='SIT';
           else if ($specialite=='MSIQ') $specialite='SIQ';
           else if ($specialite=='MSIL') $specialite='SIL';
           else if ($specialite=='MMXT') $specialite='MIXTE';
           if ($critere=='plus_choisis') $req = $bdd->prepare('SELECT CodeMaster, TitreMaster, chemin, NbChoix FROM master WHERE SpecialiteMaster=? AND NbChoix>0 ORDER BY NbChoix DESC LIMIT 0,10');
           else if($critere=='moins_choisis') $req = $bdd->prepare('SELECT CodeMaster, TitreMaster, chemin, NbChoix FROM master WHERE SpecialiteMaster=? AND NbChoix>0 ORDER BY NbChoix LIMIT 0,10');
           else if ($critere=='non_choisis') $req = $bdd->prepare('SELECT CodeMaster, TitreMaster, chemin FROM master WHERE SpecialiteMaster=? AND NbChoix=0');
           $req->execute(array($specialite)); 
         } ?>

           <table>
          <?php while ($donnees=$req->fetch()) { 
            if ($cpt==1) { 
               echo '<p style="text-align:left"> Spécialité: '.$specialite.' (master)</p> '; 
               if ($critere=='non_choisis') echo '<p style="text-align:left"> critère de recherche: les sujets non choisis</p>';
               else if ($critere=='plus_choisis') echo '<p style="text-align:left"> critère de recherche: les 10 sujets les plus choisis</p>';
               else if ($critere=='moins_choisis') echo '<p style="text-align:left"> critère de recherche: les 10 sujets les moins choisis</p>';?>
            <tr>
              <th>Code Master</th>
              <th>Titre Master</th>
           <?php  if ($critere!='non_choisis') { ?> <th>Nombre de choix</th> <?php } ?>
              <th>Lien de visualisation</th>
            </tr> <?php }
            echo '<tr>';
            echo '<td>'.$donnees['CodeMaster'].'</td>';
            echo '<td id="titre">'.$donnees['TitreMaster'].'</td>';
            if ($critere!='non_choisis') echo '<td>'.$donnees['NbChoix'].'</td>';
            echo '<td><a href='.$donnees['chemin'].' target="_blank"> visualiser la fiche descriptive </a></td>';
            echo '</tr>';
            $cpt=2;
            }
            echo '</table>';
            $req->closeCursor();
      }
  }
?>
 </div>
</body>
 <?php
	 require( __DIR__.'/'.'../../php/_footer.php');
  ?>
  <script type="text/javascript">
    var urlmenu = document.getElementById( 'menu1' );
    urlmenu.onchange = function() {
        window.open( this.options[ this.selectedIndex ].value );
                    };
    </script>
</html>

