<?php
$_SESSION['desactivation-errors'] = "";

$_SESSION['donnees-utilisateur'] = [];

$data = [];

$errors = [];

if (isset($_POST['desactivation'])) {

	if (check_password_exist(($_POST['mot_de_passe']), $_SESSION['utilisateur_connecter_bibliothecaire']['id'])) {
		if (desactiver_utilisateur($_SESSION['utilisateur_connecter_bibliothecaire']['id'])) {
			session_destroy();
			header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
		}
	} else {
		$_SESSION['desactivation-errors'] = "La desactivation à echouer. Vérifier votre mot de passe et réessayer.";
		header('location:' . PROJECT_ROM . 'bibliothecaire/mon_profil/profil');
	}
} else {
	die('no good at all');
}

