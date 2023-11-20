<?php

if (!empty($_POST['precedent'])) {
    if ($_POST['precedent'] <= 0) {
        $_SESSION['page_ouvrages'] = 1;
    } else {
        $_SESSION['page_ouvrages'] = $_POST['precedent'];
    }
}

if (!empty($_POST['suivant'])) {
    $_SESSION['page_ouvrages'] = $_POST['suivant'];
}

if (!empty($_SESSION['page_ouvrages'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/listes_ouvrages');
}

if (!empty($_POST['search']) && !empty($_POST['titre'])) {
    $_SESSION['titre'] = $_POST['titre'];
    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/listes_ouvrages');
}

if (!empty($_POST['edit'])) {
    $_SESSION['cod_ouv'] = $_POST['edit'];
    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/modifier_ouvrages');
}

if (!empty($_POST['delete'])) {
    if (suppression_ouvrage($_POST['delete'])) {
        $_SESSION['global_bibliothecaire_success'] = 'Ouvrage supprimé avec succès.';
    }
    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/listes_ouvrages');
}
