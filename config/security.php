<?php

	function redirect($path){
		header('Location: '.$path);
	}

 function hasRole($type,$role) {

	$bool =true;
	if ($role != null){
		if ($type == $role){
			$bool = true;
		}else {
			switch ($role){
				case 'user' :
					$bool = ($type != null);
					break;
				case 'enseignant' :
					$bool = ($type == 'responsable');
					break;
				case 'employe' :
					$bool = ($type == 'responsable');
					break;
				default :
					$bool = false;
					break;
			}
		}
	}else $bool = true;
	return $bool;
}
 function supprime_code_html(&$donne){
	if (is_array($donne)){
		foreach ($donne as $key => $value){
			$tmp = $donne[$key];
			supprime_code_html($tmp);
			$donne[$key] = $tmp;
		}
	}elseif (is_string($donne)){
		$donne = strip_tags($donne);
	}
}
 function security($role_allow = null) {
	// test si il have role_allow

	 if (isset($_SESSION['type'])) {
		$type =  $_SESSION['type'];
	}else $type = null;

	if ($role_allow != null) {
		if ($type == null) {

			redirect('/login');
		return false;
		} elseif (!hasRole($type, $role_allow)) {
			redirect('/not_allowed');
			return false;
		}
	}

	if (isset($_POST))
		supprime_code_html($_POST);
	if (isset($_GET))
		supprime_code_html($_GET);
	return true;

}

