<?php
	require 'security.php';
	switch ($uri) {

		case '/':
			security();
			require '../src/home.php';
			break;
		case '/login':
			security();
			require '../src/login.php';
			break;
		case '/login_check':
			security();
			require '../src/authentification.php';
			break;
		case '/Mot_de_passe_oublie':
			security();
			require '../src/forget.php';
			break;
		case '/Mot_de_passe_oublie_check':
			security();
			require '../src/traitementmdpoublie.php';
			break;
		case '/nouvea_mot_de_passe':
			security();
			require '../src/chgmnt.php';
			break;
		case '/aide':
			security();
			require '../src/aide.php';
			break;
		case '/Statistiques':
			security('employe');
			require '../src/user/employe/stat_form.php';
			break;
		case '/Calendrier':
			security('user');
			require '../src/user/calendrier.php';
			break;
		case '/Changer_mot_de_passe':
			security('user');
			require '../src/user/changermdp.php';
			break;
		case '/Formulaire':
			security('enseignant');
			require '../src/user/enseignant/afficheFiche.php';
			break;
		case '/Recheche_Sujets':
			security('user');
			require '../src/user/recherche_sujet.php';
			break;
		case '/Affectations':
			security('responsable');
			require '../src/user/responsable/proposition.php';
			break;
		case '/Planification':
			security('responsable');
			require '../src/user/responsable/planification.php';
			break;
		case '/VisualisationVoeux':
			security('responsable');
			require '../src/user/responsable/VisualisationVoeux.php';
			break;
		case '/Notifications':
			security('enseignant');
			require '../src/user/notifications.php';
			break;
		case '/Notifications_check':
			security('enseignant');
			require '../src/user/traitement_notifications.php';
			break;
		case '/import_fiche':
			security('responsable');
			require '../src/user/responsable/importFiche.php';
			break;
		case '/formulaire_check':
			security('enseignant');
			require '../src/user/enseignant/traitement_formulaire.php';
			break;
		case '/nouveau_form':
			security('enseignant');
			require '../src/user/enseignant/nouveauForm2.php';
			break;
		case '/planification_check':
			security('responsable');
			require '../src/user/responsable/traitement_planification.php';
			break;
		case '/not_allowed':
			require ('../src/405_Not_Allowed.php');
			break;
		case '/methode_not_allowed':
			require ('../src/405_Method_Not_Allowed.php');
			break;
		default:
			require ('../src/404_Not_Found.php');
			break;
	}