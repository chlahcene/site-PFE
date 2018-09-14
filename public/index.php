<?php
	require __DIR__.'/../vendor/autoload.php';
	if (PHP_SESSION_NONE === session_status()){
		session_start();
	}

// methode comme GET et POST
$httpMethod = $_SERVER['REQUEST_METHOD'];
// url
$uri = $_SERVER['REQUEST_URI'];
// recupirer le url sans les variable get comme /login?nom=aghilesse recuperer seulement /login
if (false !== $pos = strpos($uri, '?')) {
	$uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
	require __DIR__.'/../config/route.php';
