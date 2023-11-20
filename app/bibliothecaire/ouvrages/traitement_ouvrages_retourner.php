<?php

$_SESSION['ouvrage_retourner_errors'] = [];
$_SESSION['global_bibliothecaire_error'] = [];
$_SESSION['global_bibliothecaire_success'] = [];
$_SESSION['data'] = [];
$errors = [];
$data = [];

//die (var_dump($_POST));

if (is_array($_POST['emprunt'])) {

    foreach ($_POST['emprunt'] as $key => $emprunt) {

        if (!empty($_POST['emprunt'][$key]) && $_POST['emprunt'][$key] != 0) {

            if (check_if_exist('emprumt', 'num_emp', $emprunt)) {

                $data['emprunt'][] = $emprunt;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Emprunt bloque le processus.';
                }
            }
        } else {
            $_SESSION['ouvrage_retourner_errors']['emprunt'] = 'Champs requis.';
        }
    }
} else {

    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Emprunt bloque le processus.';
}

if (is_array($_POST['membre'])) {

    foreach ($_POST['membre'] as $key => $membre) {

        if (!empty($_POST['membre'][$key]) && $_POST['membre'][$key] != 0) {

            if (check_if_exist('utilisateur', 'id', $membre)) {

                $data['membre'][] = $membre;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Membre bloque le processus.';
                }
            }
        } else {
            $_SESSION['ouvrage_retourner_errors']['membre'] = 'Champs requis.';
        }
    }
} else {

    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Membre bloque le processus.';
    }
}

if (is_array($_POST['ouvrage'])) {

    foreach ($_POST['ouvrage'] as $key => $ouvrage) {

        if (!empty($_POST['ouvrage'][$key]) && $_POST['ouvrage'][$key] != 0) {

            if (check_if_exist('ouvrage', 'cod_ouv', $ouvrage)) {

                $data['ouvrage'][] = $ouvrage;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Ouvrage bloque le processus.';
                }
            }
        } else {
            $_SESSION['ouvrage_retourner_errors']['ouvrage'] = 'Champs requis.';
        }
    }
} else {

    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Ouvrage bloque le processus.';
    }
}

if (is_array($_POST['etat'])) {

    foreach ($_POST['etat'] as $key => $etat) {

        if (!empty($_POST['etat'][$key]) && $_POST['etat'][$key] != 0) {

            if (in_array($etat, ['mauvais', 'bon'])) {

                $data['etat'][] = $etat;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Etat bloque le processus.';
                }
            }
        } else {
            $_SESSION['ouvrage_retourner_errors']['etat'] = 'Champs requis.';
        }
    }
} else {

    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Etat bloque le processus.';
    }
}

$errors = $_SESSION['ouvrage_retourner_errors'];

if ((sizeof($data['emprunt']) != sizeof($data['membre'])) || (sizeof($data['emprunt']) != sizeof($data['ouvrage'])) || (sizeof($data['emprunt']) != sizeof($data['etat']))) {
    $_SESSION['global_bibliothecaire_error'] = 'Certains champs requis n\'ont pas été remplis.';
}

if (empty($errors) && empty($_SESSION['global_bibliothecaire_error'])) {

    $date_effective_retour = date("Y-m-d H:i:s");

    $ouvrage_a_info_erroner = '';

    $ouvrage_effectivement_retourner = '';

    foreach ($data['emprunt'] as $key => $num_emp) {

        if (verifier_ligne_dans_ouvrage_emprunt($data['membre'][$key], $num_emp, $data['ouvrage'][$key])) {

            //die(var_dump($data['etat']));

            $_emprunt = recup_emprunt_depuis_ouvrage_emprunt($num_emp);

            if (new DateTime($date_effective_retour) > new DateTime($_emprunt['date_butoir_retour']) || $data['etat'][$key] == 'mauvais') {

                ajouter_membre_indelicat($_emprunt['num_mem'], $num_emp, $data['ouvrage'][$key], $_emprunt['date_butoir_retour'], $date_effective_retour, $data['etat'][$key]);

            }

            maj_ouvrage_emprunt($num_emp, $date_effective_retour, $data['ouvrage'][$key], $data['etat'][$key]);

            $nb_emprunter_revu = recup_ouvrage($data['ouvrage'][$key])['nb_emprunter'] - 1;

            maj_ouvrage_nb_emprunter($data['ouvrage'][$key], $nb_emprunter_revu);

            if (sizeof($data['emprunt']) == $key) {
                $ouvrage_effectivement_retourner .= recup_ouvrage($data['ouvrage'][$key])['titre'] . '.';
            } else {
                $ouvrage_effectivement_retourner .= recup_ouvrage($data['ouvrage'][$key])['titre'] . ', ';
            }
            
        } else {

            if (sizeof($data['emprunt']) == $key) {
                $ouvrage_a_info_erroner .= recup_ouvrage($data['ouvrage'][$key])['titre'] . '.';
            } else {
                $ouvrage_a_info_erroner .= recup_ouvrage($data['ouvrage'][$key])['titre'] . ', ';
            }
        }
    }

    if (!empty($ouvrage_a_info_erroner)) {
        $_SESSION['global_bibliothecaire_error'] = 'Les informations fournies pour le(s) ouvrage(s) suivant(s) sont erronées : ' . $ouvrage_a_info_erroner;
    }

    if (!empty($ouvrage_effectivement_retourner)) {
        $_SESSION['global_bibliothecaire_success'] = 'Le(s) ouvrage(s) suivants(s) ont bien été rendus à la bibliothèque  : ' . $ouvrage_effectivement_retourner;
    }

    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/ouvrages_retourner');
    
} else {

    $_SESSION['data'] = $data;
    $_SESSION['global_bibliothecaire_error'] = 'Des erreurs sont survenues. Vérifiez vos saisies et réessayer.';

    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/ouvrages_retourner');
}
