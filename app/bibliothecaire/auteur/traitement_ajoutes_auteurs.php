<?php
$data = [];
$errors = [];
$messageErreur = '';

if (verifier_info($_POST['nom_aut'])) {
    $data['nom_aut'] = trim(htmlentities($_POST['nom_aut']));
} else {
    $errors['nom_aut'] = '<p> Le champ nom est requis. Veuillez le renseigner! </p>';
}

if (verifier_info($_POST['prenom_aut'])) {
    $data['prenom_aut'] = trim(htmlentities($_POST['prenom_aut']));
} else {
    $errors['prenom_aut'] = '<p> Le champ prénom est requis. Veuillez le renseigner!</p>';
}

if (isset($_POST['nom_aut']) && !empty($_POST['nom_aut']) && isset($_POST['prenom_aut']) && !empty($_POST['prenom_aut'])) {
    $messageErreur = check_if_auteur_exist($_POST['nom_aut'], $_POST['prenom_aut']);
    if ($messageErreur) {
        $errors['auteur_existe'] = $messageErreur;
    }
}

if (empty($errors)) {
    $resultat = ajout_auteur($data["nom_aut"], $data["prenom_aut"]);

    if ($resultat) {
        $_SESSION['ajout-success'] = 'Auteur ajouté avec succès et disponible maintenant dans la liste des auteurs';
    } else {
        $_SESSION['ajout-success'] = "L'ajout de l'auteur a échoué. Veuillez réessayer le processus";
    }
} else {
    $_SESSION['ajouter-auteur-erreurs'] = $errors;
    $_SESSION['auteur-existe'] =  $messageErreur;
}

header('location:' . PROJECT_ROM . 'bibliothecaire/auteur/listes_des_auteurs');
