<?php
$langue = [];
$errors = "";

if (empty($_POST["langue"])) {
	$errors = "Le champ est vide. Veuillez le remplir.";
}

if (empty($errors)) {
	$cod_lang = $_SESSION['cod_lang'];
	$langue = trim(htmlentities($_POST['langue']));

	// Mettez à jour les informations de l'auteur dans la base de données en utilisant votre fonction appropriée
	modifier_langue($cod_lang, $langue);

	// Redirigez vers la page de liste des auteurs avec un message de succès global
    $_SESSION['modification_succès'] = 'Modification de la langue effectuée avec succès';
	header('location: ' . PROJECT_ROM . 'bibliothecaire/langues/listes_des_langues');
	exit();
}

// Stockez les erreurs dans la session et redirigez vers la page de modification langue
$_SESSION['modification_errors'] = $errors;
header('location: ' . PROJECT_ROM . 'bibliothecaire/langues/modifier_langues');
exit();