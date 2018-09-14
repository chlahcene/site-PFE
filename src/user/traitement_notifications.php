<?php
if (isset($_POST['Envoyer']) && $_POST['contenu']!='')
{
	envoyermail($_POST['ens'],$_POST['objet'],$_POST['contenu']);
	header('Location: /Notifications?etat=success');
}

else header('Location: /Notifications?etat=fail');


?>