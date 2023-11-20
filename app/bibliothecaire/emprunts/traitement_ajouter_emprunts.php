<?php
$_SESSION['ajout_emprunt_errors'] = [];
$_SESSION['global_bibliothecaire_error'] = [];
$_SESSION['global_bibliothecaire_success'] = [];
$_SESSION['data'] = [];
$errors = [];
$data = [];

if (!empty($_POST['num_mem']) && $_POST['num_mem'] != 0) {
    
    if (check_if_exist('utilisateur', 'id', $_POST['num_mem'])) {
        
        $membre = $_POST['num_mem'];
        $data['num_mem'] = $_POST['num_mem'];
    } else {
        
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Membre bloque le processus.';
    }
    
} else {
    $_SESSION['ajout_emprunt_errors']['num_mem'] = 'Champs requis.';
}


if (is_array($_POST['cod_ouv'])) {

    if (!empty($_POST['cod_ouv']) && $_POST['cod_ouv'][0] != 0) {
        
        foreach ($_POST['cod_ouv'] as $key => $ouvrage) {

            if (check_if_exist('ouvrage', 'cod_ouv', $ouvrage)) {
                //die('yes');
                $data['cod_ouv'][] = $ouvrage;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
                }
            }
        }
    } else {
        //die('no');
        $_SESSION['ajout_emprunt_errors']['cod_ouv'] = 'Champs requis.';
    }

} else {
    //die('no_too');
    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
    }
}

$errors = $_SESSION['ajout_emprunt_errors'];

if (empty($errors) && empty($_SESSION['global_bibliothecaire_error'])) {

    $emprunts = liste_emprunts();

    if (empty($emprunts)) {
        $n = 1;
    }
    else {

        $dernier_numero_emprunt = $emprunts[sizeof($emprunts)-1]['num_emp'];

        $deuxiemeIndex = explode('/', $dernier_numero_emprunt)[1];

        $n = ltrim($deuxiemeIndex, '0');

        $n += 1;
        
    }

    $emprunt_enregistrer = ajout_emprunt_recup_emprunt('BPE/' . '000' . $n . '/' . date('y'), $membre, 1);

    if (!empty($_POST['cod_ouv'])) {
        foreach ($_POST['cod_ouv'] as $key => $ouvrage) {
            $nb_emprunter = 1;
            if (!is_null(recup_ouvrage($ouvrage)['nb_emprunter'])) {
                $nb_emprunter = recup_ouvrage($ouvrage)['nb_emprunter'] + 1;
            }
            assoc_emprunt_ouvrages($membre, $emprunt_enregistrer['num_emp'], $ouvrage);
            maj_ouvrage_nb_emprunter($ouvrage, $nb_emprunter);
        }
    }

    if (empty($_POST['more'])) {

        $_SESSION['global_bibliothecaire_success'] = 'Emprunt(s) ajouté(s) avec succès.';
        header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
    } elseif (!empty($_POST['more'])) {

        $_SESSION['global_bibliothecaire_success'] = 'Précédent(s) emprunt(s) ajouté(s) avec succès.';
        header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/ajouter_emprunts');
    }
} else {

    if (!empty($_POST['more'])) {
        $data['more'] = $_POST['more'];
    }

    $_SESSION['data'] = $data;
    $_SESSION['global_bibliothecaire_error'] = 'Des erreurs sont survenues. Vérifiez vos saisies et réessayer.';

    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/ajouter_emprunts');
}
