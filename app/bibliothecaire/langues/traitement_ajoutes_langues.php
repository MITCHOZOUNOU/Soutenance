<?php
$data = "";
$errors = "";

if (verifier_info($_POST['langue'])) {
    $data = trim(htmlentities($_POST['langue']));
} else {
    $errors = '<p> Le champ est requis. Veuillez le renseigner! </p>';
}

if (empty($errors)) {
    if (isset($_POST['langue']) && !empty($_POST['langue']) && check_if_langue_exist($_POST['langue'])) {
        $errors = 'La langue que vous essayez d\'ajouter existe déjà';
        $_SESSION['langue-existe'] = $errors;
        header('location:' . PROJECT_ROM . 'bibliothecaire/langues/listes_des_langues');
        exit();
    } else {
        $data = trim(htmlentities($_POST['langue']));
    }
}

if (empty($errors)) {
    $resultat = ajout_langue($data);
    if ($resultat) {
        $_SESSION['ajout-success'] = 'Langue ajoutée avec succès et disponible maintenant dans la liste des auteurs';
        header('location:' . PROJECT_ROM . 'bibliothecaire/langues/listes_des_langues');
        exit();
    } else {
        $_SESSION['ajout-errors'] = "L'ajout de l'auteur a échoué. Veuillez réessayer le processus";
        header('location:' . PROJECT_ROM . 'bibliothecaire/langues/ajouter_langues');
        exit();
    }
} else {
    $_SESSION['ajouter-langue-errors'] = $errors;
    header('location:' . PROJECT_ROM . 'bibliothecaire/langues/ajouter_langues');
    exit();
}
