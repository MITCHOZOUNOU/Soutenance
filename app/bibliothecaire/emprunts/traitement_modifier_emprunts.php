<?php

$_SESSION['modifier_emprunt_errors'] = [];
$_SESSION['global_bibliothecaire_error'] = [];
$_SESSION['global_bibliothecaire_success'] = [];
$_SESSION['data'] = [];
$errors = [];
$data = [];

$emprunt = recup_emprunt_par_num_emp($_SESSION['num_emp']);

if (!empty($_POST['num_mem']) && $_POST['num_mem'] != 0) {

    if (check_if_exist('utilisateur', 'id', $_POST['num_mem'])) {
        $membre = $_POST['num_mem'];
        $data['num_mem'] = $_POST['num_mem'];
    } else {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Membre bloque le processus.';
    }
} else {
    $_SESSION['modifier_emprunt_errors']['num_mem'] = 'Champs requis.';
}


if (is_array($_POST['cod_ouv'])) {

    if (!empty($_POST['cod_ouv']) && $_POST['cod_ouv'][0] != 0) {

        foreach ($_POST['cod_ouv'] as $key => $ouvrage) {

            if (check_if_exist('ouvrage', 'cod_ouv', $ouvrage)) {

                $data['cod_ouv'][] = $ouvrage;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
                }
            }
        }
    } else {
        $_SESSION['modifier_emprunt_errors']['cod_ouv'] = 'Champs requis.';
    }
} else {
    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
    }
}

$errors = $_SESSION['modifier_emprunt_errors'];

if (empty($errors) && empty($_SESSION['global_bibliothecaire_error'])) {

    maj_emprunt($_SESSION['num_emp'], $membre);

    foreach ($_POST['cod_ouv'] as $key => $ouvrage) {
        rem_old_assoc_emprunt_ouvrages($_SESSION['num_emp']);
    }

    foreach ($_POST['cod_ouv'] as $key => $ouvrage) {
        maj_assoc_emprunt_ouvrages($membre, $_SESSION['num_emp'], $ouvrage, date('Y-m-d H:i:s', strtotime($emprunt['creer_le'] . " +1 week")));
    }
    

    $_SESSION['global_bibliothecaire_success'] = 'Emprunt modifié avec succès.';
    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
} else {

    $_SESSION['data'] = $data;
    $_SESSION['global_bibliothecaire_error'] = 'Des erreurs sont survenues. Vérifiez vos saisies et réessayer.';

    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/modifier_emprunts');
}
