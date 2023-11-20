<?php

if (!empty($_POST['precedent'])) {
    if ($_POST['precedent'] <= 0) {
        $_SESSION['page_emprunts'] = 1;
    } else {
        $_SESSION['page_emprunts'] = $_POST['precedent'];
    }
}

if (!empty($_POST['suivant'])) {
    $_SESSION['page_emprunts'] = $_POST['suivant'];
}

if (!empty($_SESSION['page_emprunts'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
}

if (!empty($_POST['approve'])) {

    approuver_emprunt($_POST['approve']);

    $emprunt_approuver = recup_emprunt_par_num_emp($_POST['approve']);

    maj_date_approb_butoir($emprunt_approuver['num_emp'], $emprunt_approuver['date_approbation'], date('Y-m-d H:i:s', strtotime($emprunt_approuver['date_approbation'] . " +1 week")));

    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
}

if (!empty($_POST['search'])) {

    if (!empty($_POST['num_emp'])) {
        $_SESSION['num_empt'] = $_POST['num_emp'];
    }

    if (!empty($_POST['num_mem'])) {
        $_SESSION['num_mem'] = $_POST['num_mem'];
    }

    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
}

if (!empty($_POST['edit'])) {
    $_SESSION['num_emp'] = $_POST['edit'];
    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/modifier_emprunts');
}

if (!empty($_POST['delete'])) {
    if (suppression_emprunt($_POST['delete'])) {
        $_SESSION['global_bibliothecaire_success'] = 'Emprunt supprimé avec succès.';
    }
    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
}
