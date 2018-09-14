<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/monstyleImportFiche.css">
</head>
<body>
  <form method="post" action="/import_fiche" enctype="multipart/form-data">
      <fieldset id="form">
    	  <a href="helpImport" target="_blank">AIDE</a><br><br>
          <input type="hidden" name="MAX_FILE_SIZE" value="10000">    
          <input type="file" name="fichier" > <br>  
          <input type="submit" value="importer">
       </fieldset> 
</form>

<?php

if (isset($_FILES['fichier']))
{
	if($_FILES['fichier']['type']!='text/pdf' || $_FILES['fichier']['size']>$_POST['MAX_FILE_SIZE']) //controle d'extension.
	{   
		if ($_FILES['fichier']['type']!='text/pdf') { ?><script>alert("FORMAT INCORRECT: veuillez uploader un fichier pdf.");</script><?php }
	    if ($_FILES['fichier']['size']>$_POST['MAX_FILE_SIZE']) { ?><script>alert('fichier trop volumineux');</script><?php }
	}
	else
	{
		if (file_exists(__DIR__.'/../../../public/pfemaster/'.$_FILES['fichier']['name']))//controle d'existence du fichier uploadé
		{  
           ?><script>alert("cette fiche a déja été importée.");</script><?php
           
		}
        else 
        {
        	$result=move_uploaded_file($_FILES['fichier']['tmp_name'],__DIR__.'/../../../public/pfemaster/'.$_FILES['fichier']['name']);
            if ($result) 
            { //processus d'importation de la fiche dans la base de données:
				      require __DIR__.'/../../php/fonctions.php';
				      $bdd = connecterBDD();
              $tab = stringToArraySujet(pdfToString($_FILES['fichier']['name']))
              if (!$tab['isMaster'])//specialité pfe/non master
              {
                $req = $bdd->prepare('INSERT INTO pfe(CodePFE, AnneeUniversitaire, TitrePFE, mots_cles, SpecialitePFE, PFEID, NbChoix, chemin) VALUES(:CodePFE, :AnneeUniversitaire, :TitrePFE, :mots_cles, :SpecialitePFE, :PFEID, :NbChoix, :chemin)');
                $req->execute(array(
                'CodePFE' => $tab['CODE'],
                'AnneeUniversitaire' => $tab["ANNEE UNIVERSITAIRE"],
                'TitrePFE' => $tab['TITRE'],
                'mots_cles' => $tab['MOTS CLES'],
                'SpecialitePFE' => $tab['CODE'],
                'PFEID'=>$tab['ID'],
                'NbChoix'=>0,
                'chemin'=>$tab['chemin']
                 ));
                $req->closeCursor();
                ?><script>alert('fiche importée avec succés');</script><?php 
              }
            }
            else { ?><script>alert('l\'importation a échoué !')</script><?php }
        }
	}

}

?>
</body>
</html>
