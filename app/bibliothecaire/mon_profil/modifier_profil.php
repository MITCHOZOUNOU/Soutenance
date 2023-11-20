<?php
$_SESSION['passe'] = "";
$_SESSION['success'] = "";

$data = $_SESSION["utilisateur_connecter_bibliothecaire"];
$new_data = [];
$errors = [];

if (isset($_POST['nom']) && !empty($_POST['nom']) && $_POST['nom'] != $data['nom']) {
    $new_data['nom'] = trim(htmlentities($_POST['nom']));
} else {
    $new_data['nom'] = $data['nom'];
}

if (isset($_POST['prenom']) && !empty($_POST['prenom']) && $_POST['prenom'] != $data['prenom']) {
    $new_data['prenom'] = trim(htmlentities($_POST['prenom']));
} else {
    $new_data['prenom'] = $data['prenom'];
}

if (isset($_POST['telephone']) && !empty($_POST['telephone']) && $_POST['telephone'] != $data['telephone']) {
    $new_data['telephone'] = trim(htmlentities($_POST['telephone']));
} else {
    $new_data['telephone'] = $data['telephone'];
}

if (isset($_POST['nom_utilisateur']) && !empty($_POST['nom_utilisateur']) && $_POST['nom_utilisateur'] != $data['nom_utilisateur']) {
    $new_data['nom_utilisateur'] = trim(htmlentities($_POST['nom_utilisateur']));
} else {
    $new_data['nom_utilisateur'] = $data['nom_utilisateur'];
}

if (isset($_POST['adresse']) && !empty($_POST['adresse']) && $_POST['adresse'] != $data['adresse']) {
    $new_data['adresse'] = trim(htmlentities($_POST['adresse']));
} else {
    $new_data['adresse'] = $data['adresse'];
}

if (isset($_POST['date_naissance']) && !empty($_POST['date_naissance']) && $_POST['date_naissance'] != $data['date_naissance']) {
    $new_data['date_naissance'] = trim(htmlentities($_POST['date_naissance']));
} else {
    $new_data['date_naissance'] = $data['date_naissance'];
}

if (isset($_POST['sexe']) && !empty($_POST['sexe']) && $_POST['sexe'] != $data['sexe']) {
    $new_data['sexe'] = trim(htmlentities($_POST['sexe']));
} else {
    $new_data['sexe'] = $data['sexe'];
}

$new_data['avatar'] = "";

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"])) {
    if (!check_password_exist($_POST['mot_de_passe'], $data['id'])) {
        $errors["mot_de_passe"] = "Le mot de passe est incorrect.";
    }
} else {
    $errors["mot_de_passe"] = "Le champ du mot de passe est vide. Veuillez le renseigner.";
}


$_SESSION["modifier-profil-erreur"] = $errors;
$_SESSION["modifier-profil-donnees"] = $new_data;

if (empty($errors)) {
    if (mettre_a_jour_informations_utilisateur(
        $data['id'],
        $new_data['nom'],
        $new_data['prenom'],
        $new_data['sexe'],
        $new_data['date_naissance'],
        $new_data['telephone'],
        $new_data['nom_utilisateur'],
        $new_data['adresse']
    )) {
        if (recup_mettre_a_jour_informations_utilisateur($data['id'])) {
            $_SESSION["utilisateur_connecter_bibliothecaire"] = recup_mettre_a_jour_informations_utilisateur($data['id']);
            $_SESSION['success'] = "Modifications effectuées avec succès";
        } else {
            $_SESSION['passe'] = "La modification a échoué. Veuillez vérifier votre mot de passe et réessayer.";
        }
    }
}

header('location:' . PROJECT_ROM . 'bibliothecaire/mon_profil/profil');
