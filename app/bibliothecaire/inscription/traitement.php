<?php
$data = [];
$message_erreur_global = "";
$message_success_global = "";
$errors = [];

//Je vérifie si les informations envoyés par le visiteur sont corrrects.


if (verifier_info($_POST['nom'])){
    $data['nom']=htmlspecialchars($_POST['nom']) ;
}
else{
       $errors['nom'] = '<p> Le champs nom est requis. Veuillez le renseigner! </p>';
}

if(verifier_info($_POST['prenom'])){
    $data['prenom']= htmlspecialchars($_POST['prenom']) ;
}
else{
        $errors['prenom']= '<p > Le champs prénom est requis. Veuillez le renseigner!</p>';
}


if (isset($_POST["nom_utilisateur"]) && !empty($_POST["nom_utilisateur"])) {
    $data["nom_utilisateur"] = $_POST["nom_utilisateur"];
} else {
    $errors["nom_utilisateur"] = "Le champs nom utilisateur est requis. Veuillez le renseigner.";
}


if (isset($_POST["email"]) && !empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $data["email"] = $_POST["email"];
} 
else{
        $errors['email'] = '<p>Le champs email est requis ou est déjà utlisé. Veuillez le renseigner!</p>';
}

if (!isset($_POST["mot_de_passe"]) || empty($_POST["mot_de_passe"])) {
    $errors["mot_de_passe"] = "Le champs du mot de passe est vide. Veuillez le renseigner.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen(($_POST["mot_de_passe"])) < 8) {
    $errors["mot_de_passe"] = "Le champs doit contenir minimum 8 caractères. Les espaces ne sont pas pris en compte.";
}

if (isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen(($_POST["mot_de_passe"])) >= 8 && empty($_POST["repeter_le_mot_de_passe"])) {
    $errors["repeter_le_mot_de_passe"] = "Entrez votre mot de passe à nouveau.";
}

if ((isset($_POST["repeter_le_mot_de_passe"]) && !empty($_POST["repeter_le_mot_de_passe"]) && strlen(($_POST["mot_de_passe"])) >= 8 && $_POST["repeter_le_mot_de_passe"] != $_POST["mot_de_passe"])) {
    $errors["repeter_le_mot_de_passe"] = "Mot de passe erroné. Entrez le mot de passe du précédent champs";
}

if ((isset($_POST["mot_de_passe"]) && !empty($_POST["mot_de_passe"]) && strlen(($_POST["mot_de_passe"])) >= 8 && $_POST["repeter_le_mot_de_passe"] == $_POST["mot_de_passe"])) {
    $data["mot_de_passe"] = $_POST['mot_de_passe'];
}




$check_email_exist_in_bdd  = check_email_exist_in_bdd($_POST["email"]);

if ($check_email_exist_in_bdd ) {
    $errors["email"] = "Cette adresse mail est déja utilisé. Veuillez le changer.";
}

$check_user_name_exist_in_bdd = check_user_name_exist_in_bdd($_POST["nom_utilisateur"]);

if ($check_user_name_exist_in_bdd) {
    $errors["nom_utilisateur"] = "Ce nom d'utilisateur est déja utilisé. Veuillez le changer.";
}

$_SESSION['donnees-utilisateur'] = $data;
    $_SESSION['inscription-erreurs'] = $errors;

$data["profil"] = "BIBLIOTHECAIRE";


if (empty($errors)) {

    $resultat = enregistrer_utilisateur($data["nom"], $data["prenom"], $data["email"], $data["nom_utilisateur"], $data["mot_de_passe"], $data["profil"]);
// die(var_dump($resultat));
    if ($resultat) {
      
                $message_success_global = "Votre inscription s'est effectuée avec succès. Veuillez contacter votre administrateur pour la validation de votre compte";
        
    } else {
        $message_erreur_global = "Oups ! Une erreur s'est produite lors de l'enregistrement de l'utilisateur.";
        header('location: ' . PROJECT_ROM . 'bibliothecaire/inscription');
    }
} else {
    
    
}
$_SESSION['inscription-message-erreur-global'] = $message_erreur_global;
$_SESSION['inscription-message-success-global'] = $message_success_global;
header('location: ' . PROJECT_ROM . 'bibliothecaire/inscription');
