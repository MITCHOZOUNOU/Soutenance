<?php
$_SESSION['changement-erreurs'] = [];

$data = [];

$errors = [];


if (!isset($_POST["nouveau_mot_de_passe"]) || empty($_POST["nouveau_mot_de_passe"])) {
	$errors["nouveau_mot_de_passe"] = "Le champ du nouveau mot de passe est vide. Veuillez le renseigner.";
}

if (isset($_POST["nouveau_mot_de_passe"]) && !empty($_POST["nouveau_mot_de_passe"]) && strlen(($_POST["nouveau_mot_de_passe"])) < 8) {
	$errors["nouveau_mot_de_passe"] = "Le champ doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if (isset($_POST["nouveau_mot_de_passe"]) && strlen(($_POST["nouveau_mot_de_passe"])) >= 8) {
	$data["nouveau_mot_de_passe"] = trim(htmlentities($_POST['nouveau_mot_de_passe']));
}

if (isset($_POST["nouveau_mot_de_passe"]) && !empty($_POST["nouveau_mot_de_passe"]) && strlen(($_POST["nouveau_mot_de_passe"])) >= 8 && empty($_POST["confirmer_mot_de_passe"])) {
	$errors["confirmer_mot_de_passe"] = "Entrez votre mot de passe à nouveau.";
}

if ((isset($_POST["confirmer_mot_de_passe"]) && !empty($_POST["confirmer_mot_de_passe"]) && strlen(($_POST["nouveau_mot_de_passe"])) >= 8 && $_POST["confirmer_mot_de_passe"] != $_POST["nouveau_mot_de_passe"])) {
	$errors["confirmer_mot_de_passe"] = "Mot de passe erroné. Entrez le mot de passe du précédent champs";
}

if ((isset($_POST["nouveau_mot_de_passe"]) && !empty($_POST["nouveau_mot_de_passe"]) && strlen(($_POST["nouveau_mot_de_passe"])) >= 8 && $_POST["confirmer_mot_de_passe"] == $_POST["nouveau_mot_de_passe"])) {
	$data["nouveau_mot_de_passe"] = trim(htmlentities($_POST['nouveau_mot_de_passe']));
}

if (!check_password_exist(($_POST['mot_de_passe']), $_SESSION['utilisateur_connecter_bibliothecaire']['id'])) {
	$errors["mot_de_passe"] = "Mot de passe incorrecte. Veuillez réessayer";
}


if (empty($errors)) {

	if (check_password_exist(($_POST['mot_de_passe']), $_SESSION['utilisateur_connecter_bibliothecaire']['id'])) {

		if (update_password_in_bdd($_SESSION['utilisateur_connecter_bibliothecaire']['id'], $data["nouveau_mot_de_passe"])) {
			session_destroy();
			header('location:' . PROJECT_ROM . 'bibliothecaire/connexion');
		} else {
			die('no good at all');
		}
	} else {

	}
} else {
	$_SESSION['errors'] = $errors;
	header('location:' . PROJECT_ROM . 'bibliothecaire/mon_profil/profil');
}
