<?php

$_SESSION['modifier_emprunt_errors'] = [];
$_SESSION['global_membre_error'] = [];
$_SESSION['global_membre_success'] = [];
$_SESSION['data'] = [];
$errors = [];
$data = [];

$emprunt = recup_emprunt_par_num_emp($params[3]);

if (is_array($_POST['cod_ouv'])) {

    if (!empty($_POST['cod_ouv']) && $_POST['cod_ouv'][0] != 0) {

        foreach ($_POST['cod_ouv'] as $key => $ouvrage) {

            if (check_if_exist('ouvrage', 'cod_ouv', $ouvrage)) {

                $data['cod_ouv'][] = $ouvrage;
            } else {
                if (empty($_SESSION['global_membre_error'])) {
                    $_SESSION['global_membre_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
                }
            }
        }
    } else {
        $_SESSION['modifier_emprunt_errors']['cod_ouv'] = 'Champs requis.';
    }
} else {
    if (empty($_SESSION['global_membre_error'])) {
        $_SESSION['global_membre_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
    }
}

$errors = $_SESSION['modifier_emprunt_errors'];

if (empty($errors) && empty($_SESSION['global_membre_error'])) {

    foreach ($_POST['cod_ouv'] as $key => $ouvrage) {
        rem_old_assoc_emprunt_ouvrages($params[3]);
    }

    foreach ($_POST['cod_ouv'] as $key => $ouvrage) {
        maj_assoc_emprunt_ouvrages($_SESSION['utilisateur_connecter_membre']['id'], $params[3], $ouvrage, date('Y-m-d H:i:s', strtotime($emprunt['creer_le'] . " +1 week")));
    }
    

    $_SESSION['global_membre_success'] = 'Emprunt modifié avec succès.';
    header('location:' . PROJECT_ROM . 'membre/historique_emprunts');
} else {

    $_SESSION['data'] = $data;
    $_SESSION['global_membre_error'] = 'Des erreurs sont survenues. Vérifiez vos saisies et réessayer.';

    header('location:' . PROJECT_ROM . 'membre/modifier_emprunt');
}
