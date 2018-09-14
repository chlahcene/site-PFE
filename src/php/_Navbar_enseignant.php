<ul class="navbar-nav mr-auto">

      <li class="nav-item ">
        <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="/Formulaire">Formulaire</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="/Recheche_Sujets">Recheche Sujets</a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="/Calendrier">Calendrier</a>
      </li>
    <li class="nav-item ">
        <a class="nav-link" href="/Notifications"><?php if ($nbrNotifNonLu != 0) {
				# code...
				?>

                Notifications <span class="badge badge-success"><?=$nbrNotifNonLu ?></span>
			<?php }else echo "Notifications";  ?>
        </a>
    </li>
     <li class="nav-item ">
        <a class="nav-link" href="/Changer_mot_de_passe">Changer mot de passe</a>
      </li>
    </ul>
