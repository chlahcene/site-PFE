

<div class="jumbotron" style="text-align: center;background-color: white">
  <h1 class="display-4" >Bienvenue au Site</h1>
  <h3 class="display-5" style="color:#088A85 " >Gestion Des PFE</h3>
  <br>
  <br>
  <p class="lead">Plateforme de gestion des PFE a L'ecole Nationale Superieure d'Informatique ESI Ex INI.</p>
  <hr class="my-4">
  <?php 
  if($var=='Connexion') { ?> 
    <p>Connectez-vous en tant que Enseignant ou Employé ou Responsable pour beneficier de notre site.</p>
  <?php } 
  else if ($var=='Deconnexion') { echo '<p>'.$_SESSION['id'].'</p> ';
                                  echo '<p>fonction: '.$_SESSION['type'].'</p>'; } ?>
  <br>

  <p class="lead">
   <span> <a class="btn btn-lg" href="/aide" role="button" style="background-color: #088A85">Page D'aide</a>
        <a class="btn btn-lg" href="/login?etat=<?= $var ?>" value="<?= $var ?>" name="connecter" role="button" style="background-color: #088A85"><?= $var ?></a>
</span>
  </p>
</div>