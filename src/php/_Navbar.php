<?php
	$nbrNotifNonLu = 0;
    if (isset($_SESSION['nbrNotifs'])){
        if ($_SESSION['nbrNotifs']>0) $nbrNotifNonLu = $_SESSION['nbrNotifs'];
    }
    if (isset($_SESSION['type'])){
        $role = $_SESSION['type'];
    }


?>
<nav class="navbar navbar-expand-lg navbar-light bg-light" >
    <img src="image/logoesi.png" class="logoesi">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText" >
        <?php
            if (isset($role)){
                if ($role == 'enseignant'){
					require __DIR__.'/'.'_Navbar_enseignant.php';
                }else if ($role == 'employe'){
					 require __DIR__.'/'.'_Navbar_employe.php';
				}else if ($role == 'responsable'){
					 require __DIR__.'/'.'_Navbar_responsable.php';
				}
            }else require __DIR__.'/'. '_Navbar_home.php';
        ?>
    </div>
</nav>