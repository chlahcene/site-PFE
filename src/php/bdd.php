<?php
	function connecterBDD(){
		try {
			$param = require __DIR__.'/../../config/config.php';
			return new PDO(
					'mysql:host='.$param['BDD.host'].
					';dbname='.$param['BDD.name'].';charset=utf8',
					$param['BDD.username'],
					$param['BDD.password'],
					array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					)
			);
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
	}