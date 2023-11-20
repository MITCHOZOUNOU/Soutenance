<?php
$domaine = [];
$errors = "";

if (empty($_POST["domaine"])) {
	$errors = "Le champ est vide. Veuillez le remplir.";
}

if (empty($errors)) {
	$cod_dom = $_SESSION['cod_dom'];
	$domaine = trim(htmlentities($_POST['domaine']));

	// Mettez à jour les informations du domaine dans la base de données en utilisant votre fonction appropriée
	modifier_domaine($cod_dom, $domaine);

	// Redirigez vers la page de liste des domaines avec un message de succès global
    $_SESSION['modification_succès'] = 'Modification du domaine effectuée avec succès';
	header('location: ' . PROJECT_ROM . 'bibliothecaire/domaines/listes_domaines');
	exit();
}

// Stockez les erreurs dans la session et redirigez vers la page de modification domaine
$_SESSION['modification_errors'] = $errors;
header('location: ' . PROJECT_ROM . 'bibliothecaire/domaines/modifier_domaines');
exit();