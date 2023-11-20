<?php

$data = [];
$alerte = [];
$erreurs = [];
$_SESSION['data'] = [];

if (isset($_POST["nom_utilisateur"]) && !empty($_POST["nom_utilisateur"])) {
    $data["nom_utilisateur"] = $_POST["nom_utilisateur"];
} else {
    $erreurs["nom_utilisateur"] = "Le champs nom utilisateur est requis. Veuillez le renseigner.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"])) {
    $data["mot_de_passe"] = $_POST["mot_de_passe"];
} else {
    $erreurs["mot_de_passe"] = "Le champs du mot de passe est vide. Veuillez le renseigner.";
}
$_SESSION['data'] = $data;

if (empty($erreurs)) {
    $user = check_if_user_exist($data["nom_utilisateur"], $data["mot_de_passe"], "MEMBRE", 1, 0);

    //si l'utilisateur appuie sur le checkbox "se rappeler de moi"
    if (isset($_POST['se_rappeler']) and !empty($_POST['se_rappeler'])) {

        //je crée un cookie pour enrégistreé ses données.
        setcookie(
            "data_users",
            json_encode($data['nom_utilisateur']),
            [
                'expires' => time() + 365 * 24 * 3600,
                'path' => '/',
                'secure'  => true,
                'httponly'  => true,
            ]
        );
    }
    // S'il ne coche pas sur le checkbox "se rappeler de moi"
    //Je modifie le cookie en le vidant 
    else {
        setcookie(
            "data_users",
            "",
            [
                'expires' => time() + 365 * 24 * 3600,
                'path' => '/',
                'secure'  => true,
                'httponly'  => true,


            ]
        );
    }

    if (!empty($user)) {
        $_SESSION["utilisateur_connecter_membre"] = $user;
        header('location:' . PROJECT_ROM . 'membre/accueil/');
    } else {
        $_SESSION['alerte'] = "Nom d'utilisateur ou mot de passe incorrect. Veuillez le verifier";
    }
} else {
    $_SESSION['erreurs'] = $erreurs;
}

header('location:' . PROJECT_ROM . 'membre/connexion');
