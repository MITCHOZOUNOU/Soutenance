<?php
$data = "";
$errors = "";

if (isset($_POST['domaines'])) {
    $domaine = trim(htmlentities($_POST['domaines']));

    if (empty($domaine)) {
        $errors = '<p> Le champ est requis. Veuillez le renseigner! </p>';
    } elseif (check_if_domaine_exist($domaine)) {
        $errors = 'Le domaine que vous essayez d\'ajouter existe déjà';
        $_SESSION['domaine-existe'] = $errors;
    } else {
        $data = $domaine;
    }
}

if (empty($errors)) {
    if (!empty($data)) {
        $resultat = ajout_domaine($data);
        if ($resultat) {
            $_SESSION['ajout-success'] = 'Domaine ajouté avec succès et disponible maintenant dans la liste des domaines';
            header('location:' . PROJECT_ROM . 'bibliothecaire/domaines/listes_domaines');
            exit(); // Ajoutez cette ligne pour arrêter l'exécution du script après la redirection
        } else {
            $_SESSION['ajout-errors'] = "L'ajout du domaine a échoué. Veuillez reprendre le processus";
            header('location:' . PROJECT_ROM . 'bibliothecaire/domaines/ajouter_domaines');
            exit(); // Ajoutez cette ligne pour arrêter l'exécution du script après la redirection
        }
    }
} else {
    $_SESSION['ajouter-domaines-errors'] = $errors;
    header('location:' . PROJECT_ROM . 'bibliothecaire/domaines/ajouter_domaines');
    exit(); // Ajoutez cette ligne pour arrêter l'exécution du script après la redirection
}

