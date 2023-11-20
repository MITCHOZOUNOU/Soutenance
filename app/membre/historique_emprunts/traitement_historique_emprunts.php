<?php

if (!empty($_POST['delete'])) {
    if (suppression_emprunt($_POST['delete'])) {
        $_SESSION['global_membre_success'] = 'L\'emprunt n° '.$_POST['delete'].' a été supprimé avec succès.';
    }
    header('location:' . PROJECT_ROM . 'membre/historique_emprunts/index');
}

if (!empty($_POST['search'])) {

    if (!empty($_POST['num_emp'])) {
        $_SESSION['num_empt'] = $_POST['num_emp'];
    }

    header('location:' . PROJECT_ROM . 'membre/historique_emprunts/index');
}