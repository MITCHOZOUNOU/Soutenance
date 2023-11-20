<?php

$_SESSION['donnees-utilisateur'] = [];

$data = [];

$errors = [];

if (isset($_POST['desactivation'])) {

	if (check_password_exist(($_POST['mot_de_passe']), $_SESSION['utilisateur_connecter_membre']['id'])) {
		if (desactiver_utilisateur($_SESSION['utilisateur_connecter_membre']['id'])) {
			session_destroy();
			header('location:' . PROJECT_ROM . 'membre/accueil');
		}
	} else {
		$_SESSION['global_membre_error'] = "La desactivation à echouer. Vérifier votre mot de passe et réessayer.";
		header('location:' . PROJECT_ROM . 'membre/profil/');
	}
} 
// else {
// 	die('no good at all');
// }

