<?php

if (!empty($_POST['precedent'])) {
    if ($_POST['precedent'] <= 0) {
        $_SESSION['page_membre_indelicat'] = 1;
    } else {
        $_SESSION['page_membre_indelicat'] = $_POST['precedent'];
    }
}

if (!empty($_POST['suivant'])) {
    $_SESSION['page_membre_indelicat'] = $_POST['suivant'];
}

if (!empty($_SESSION['page_membre_indelicat'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/membres_indelicats/listes_des_membres_indelicats');
}

if (!empty($_POST['search'])) {

    if (!empty($_POST['num_mem'])) {
        $_SESSION['num_mem'] = $_POST['num_mem'];
    }

    header('location:' . PROJECT_ROM . 'bibliothecaire/membres_indelicats/listes_des_membres_indelicats');
}

if (!empty($_POST['reglementer'])) {

    if (!empty($_POST['bank'])) {
        $bank = $_POST['bank'];
    }

    if (!empty($_POST['account_number'])) {
        $account_number = $_POST['account_number'];
    }

    $num_emp = explode(',', $_POST['reglementer'])[0];
    $cod_ouv = explode(',', $_POST['reglementer'])[1];

    if (!empty($bank) && !empty($account_number)) {
        maj_membre_indelicat($num_emp, $cod_ouv, $bank, $account_number);
        $_SESSION['global_bibliothecaire_success'] = 'Ce membre a bien été réglémenté pour cet ouvrage.';
    } else {
        $_SESSION['global_bibliothecaire_error'] = 'Une erreur s\'est produite. Des renseignements manquent, soit le nom de la banque, le numéro de compte ou les deux.';
    }

    header('location:' . PROJECT_ROM . 'bibliothecaire/membres_indelicats/listes_des_membres_indelicats');
}
