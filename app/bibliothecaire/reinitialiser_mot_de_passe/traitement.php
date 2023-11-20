<?php
$_SESSION['save_errors'] = [];
$data = [];
$errors = [];


if (!isset($_POST["mot_de_passe"]) || empty($_POST["mot_de_passe"])) {
    $errors["mot_de_passe"] = "Le champ du mot de passe est vide. Veuillez le renseigner.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen($_POST["mot_de_passe"]) < 8) {
    $errors["mot_de_passe"] = "Le champ doit contenir au moins 8 caractères. Les espaces ne sont pas pris en compte.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen($_POST["mot_de_passe"]) >= 8 && empty($_POST["confirmer_mot_de_passe"])) {
    $errors["confirmer_mot_de_passe"] = "Entrez à nouveau votre mot de passe.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen($_POST["mot_de_passe"]) >= 8 && $_POST["confirmer_mot_de_passe"] !== $_POST["mot_de_passe"]) {
    $errors["confirmer_mot_de_passe"] = "Mot de passe erroné. Entrez à nouveau le mot de passe du champ précédent.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen($_POST["mot_de_passe"]) >= 8 && $_POST["confirmer_mot_de_passe"] === $_POST["mot_de_passe"]) {
    $data["mot_de_passe"] = trim(htmlspecialchars($_POST['mot_de_passe']));

    if (update_password_in_bdd($_SESSION['id_user'], $data["mot_de_passe"])) {
        header('Location: ' . PROJECT_ROM . 'bibliothecaire/connexion');
        exit;
    } else {
        $_SESSION['save_errors'] = "La modification du mot de passe n'a pas pu s'effectuer. Veuillez réessayer en vous assurant de bien insérer les données cette fois-ci. ";
    }
}

if (isset($errors["mot_de_passe"]) || isset($errors["confirmer_mot_de_passe"])) {
    $_SESSION['errors'] = $errors;
    header('Location: ' . PROJECT_ROM . 'bibliothecaire/reinitialiser_mot_de_passe');
    exit;
}

header('Location: ' . PROJECT_ROM . 'bibliothecaire/reinitialiser_mot_de_passe');
exit;
?>