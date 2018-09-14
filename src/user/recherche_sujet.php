

<!DOCTYPE html>
<html>
<head>
	<title>Recherche Sujet</title>

<?php require __DIR__.'/../php/_links.php'; ?>

</head>
<body>
	<?php

		require __DIR__.'/../php/_Navbar.php';
	    require __DIR__.'/../php/fonctions.php';
	 ?>


  <br>
  <h1 class="display-4" style="text-align: center">Recherche Sujet</h1>
  <hr class="my-4">

	<form enctype="multipart/form-data" action="/Recheche_Sujets" method="post">

        <div class="col-md-4" >
            <div class="form-group" align="" >
                <!--recherche par type(master ou pfe)-->
                <input type="checkbox" name="master" id="master" /> <label for="master">Master</label>
                <input type="checkbox" name="pfe" id="pfe"  /> <label for="pfe">PFE</label> <br><br><br>
                <!--recherche par sepcialité-->
                <input type="checkbox" name="SIT" id="sit" /> <label for="sit">SIT</label>
                <input type="checkbox" name="SIQ" id="siq" /> <label for="siq">SIQ</label>
                <input type="checkbox" name="SIL" id="sil" /> <label for="sil">SIL</label>
                <input type="checkbox" name="MIXTE" id="mixte" /> <label for="mixte">MIXTE</label><br><br>

                <div class="form-group" align="" >
                    <label  style="text-align: center;">Mot clé 1  </label>
                    <input class="form-control" type="text" id="mc1" name="mots_cles[]" style="width:150px">
                    <label>Mot clé 2  </label>
                    <input class="form-control" align="center" type="text" id="mc2" name="mots_cles[]" style="width:150px">
                    <label>Mot clé 3  </label>
                    <input type="text" id="mc3" class="form-control" name="mots_cles[]" style="width:150px">
                    <!--recherche par titre-->

                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <label>Titre  </label>
            <input type="text" id="titre" name="titre" class="form-control" style="width:300px">
            <div class="help-block with-errors"></div>
        </div>
        <!--recherche par mot clé-->
        <dir>
            <br>
            <button type="submit" name="Rechercher" value="Rechercher" id="Rechercher" class="btn btn-lg" style="background-color: #088A85;border: none;"> <a style="text-decoration: none;color: white" >Rechercher</a> </button>
        </dir>
        <br><br>
        <!--      <h4 class="display-5" >Les resultats de la recherche</h4>-->
        <br>
        <div class="col-md-14" >
            <div class="form-group" align="center" >
                <select class="form-control col-md-4 col-lg-6 col-ms-12" name="menu1" id="menu1">
                    <option>Clicker ici pour visualiser le resultat</option>

					<?php
					?>
                    <?php
  recherche_sujet($tai);


  echo '</select>';
   echo '<br>','Nombre de resultats  : '.$tai;//on imprime le nombre de resultats de la recherche
                    echo '</div>';
                    echo '</div>';
                    echo '</form>';
echo '<br>';

    require __DIR__.'/../php/_footer.php';   ?>
          <!-- Fin du formulaire de recherche-->

 	<script type="text/javascript">
 		var urlmenu = document.getElementById( 'menu1' );
 		urlmenu.onchange = function() {
        window.open( this.options[ this.selectedIndex ].value );
									  };
    </script>

</body>
</html>