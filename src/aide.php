<?php
  
    if (isset($_SESSION['type'])){
        $role = $_SESSION['type'];
    }



     if (isset($role)){
                if ($role == 'enseignant'){
          require __DIR__.'/php/'.'aide enseignant.php';
                }else if ($role == 'employe'){
           require __DIR__.'/php/'.'aide employe.php';
        }else if ($role == 'responsable'){
           require __DIR__.'/php/'.'aide responsable.php';
        }
     }else require __DIR__.'/php/'. 'aide login.php';
        