<?php

$data = [];

$errors = [];

if (isset($_POST['supprimer'])) {

	if (check_password_exist(($_POST['mot_de_passe']), $_SESSION['utilisateur_connecter_membre']['id'])) {
		if (supprimer_utilisateur($_SESSION['utilisateur_connecter_membre']['id'])) {
			session_destroy();
			$_SESSION['global_membre_success'] = 'Compte supprimé avec succès.' ;
			header('location:' . PROJECT_ROM . 'membre/accueil');
		}
	} else {
		$_SESSION['global_membre_error'] = "La suppression à echouer. Vérifier votre mot de passe et réessayer.";
		header('location:' . PROJECT_ROM . 'membre/profil');
	}
} 

// else {
// 	die('no good at all');
// }
