<?php
$nom_aut = isset($_POST['nom_aut']) ? $_POST['nom_aut'] : '';
$prenoms_aut = isset($_POST['prenoms_aut']) ? $_POST['prenoms_aut'] : '';


$errors = array();

if (empty($_POST["nom_aut"])) {
	$errors['nom_aut'] = "Le champ nom est obligatoire.";
}

if (empty($_POST["prenoms_aut"])) {
	$errors['prenoms_aut'] = "Le champ prénom est obligatoire.";
}

if (empty($errors)) {
	$num_aut = $_SESSION['num_aut'];
	$nom_aut = trim(htmlentities($_POST['nom_aut']));
	$prenoms_aut = trim(htmlentities($_POST['prenoms_aut']));

	// Mettez à jour les informations de l'auteur dans la base de données en utilisant votre fonction appropriée
	modifier_auteur($num_aut, $nom_aut, $prenoms_aut);

	// Redirigez vers la page de liste des auteurs avec un message de succès global
    $_SESSION['modification_succès'] = 'Modification de l\'auteur effectuée avec succès';
	header('location: ' . PROJECT_ROM . 'bibliothecaire/auteur/listes_des_auteurs');
	exit();
}

// Stockez les erreurs dans la session et redirigez vers la page de modification de l'auteur
$_SESSION['nom_aut'] = $_POST['nom_aut'];
$_SESSION['prenoms_aut'] = $_POST['prenoms_aut'];
$_SESSION['modification_errors'] = $errors;
header('location: ' . PROJECT_ROM . 'bibliothecaire/auteur/modifier_auteur');
exit();
