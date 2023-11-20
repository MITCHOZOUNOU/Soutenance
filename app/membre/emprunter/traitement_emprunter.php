<?php
$_SESSION['ajouter_emprunt_errors'] = [];
$_SESSION['global_membre_error'] = [];
$_SESSION['global_membre_success'] = [];
$_SESSION['data'] = [];
$errors = [];
$data = [];

if (!empty($params[3])) {
    $cod_ouv = $params[3];
}

if (is_array($_POST['cod_ouv'])) {

    if (!empty($_POST['cod_ouv']) && $_POST['cod_ouv'][0] != 0) {

        foreach ($_POST['cod_ouv'] as $key => $ouvrage) {

            if (check_if_exist('ouvrage', 'cod_ouv', $ouvrage)) {
                //die('yes');
                $data['cod_ouv'][] = $ouvrage;
            } else {
                if (empty($_SESSION['global_membre_error'])) {
                    $_SESSION['global_membre_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
                }
            }
        }
    } else {
        //die('no');
        $_SESSION['ajouter_emprunt_errors']['cod_ouv'] = 'Champs requis.';
    }
} else {
    //die('no_too');
    if (empty($_SESSION['global_membre_error'])) {
        $_SESSION['global_membre_error'] = 'Une action inattendue au niveau du champs Ouvrage(s) bloque le processus.';
    }
}

$errors = $_SESSION['ajouter_emprunt_errors'];

if (empty($errors) && empty($_SESSION['global_membre_error'])) {

    $emprunts = liste_emprunts();

    if (empty($emprunts)) {
        $n = 1;
    } else {

        $dernier_numero_emprunt = $emprunts[sizeof($emprunts) - 1]['num_emp'];

        $deuxiemeIndex = explode('-', $dernier_numero_emprunt)[1];

        $n = ltrim($deuxiemeIndex, '0');

        $n += 1;
    }

    $emprunt_enregistrer = ajout_emprunt_recup_emprunt('BPE-' . '000' . $n . '-' . date('y'), $_SESSION['utilisateur_connecter_membre']['id'], 0);

    if (!empty($_POST['cod_ouv'])) {
        foreach ($_POST['cod_ouv'] as $key => $ouvrage) {
            $nb_emprunter = 1;
            if (!is_null(recup_ouvrage($ouvrage)['nb_emprunter'])) {
                $nb_emprunter = recup_ouvrage($ouvrage)['nb_emprunter'] + 1;
            }
            assoc_emprunt_ouvrages($_SESSION['utilisateur_connecter_membre']['id'], $emprunt_enregistrer['num_emp'], $ouvrage);
            maj_ouvrage_nb_emprunter($ouvrage, $nb_emprunter);
        }
    }

    $_SESSION['global_membre_success'] = 'Votre demande d\'emprunt a été soumis et est en cours d\'examen pour validation. Vous recevrez un mail après validation ou sinon consulter votre historique d\'emprunts de temps à autre pour vérifier le statut de votre emprunt.';
    header('location:' . PROJECT_ROM . 'membre/historique_emprunts');

} else {

    $_SESSION['data'] = $data;
    $_SESSION['global_membre_error'] = 'Des erreurs sont survenues. Vérifiez vos saisies et réessayer.';

    !empty($cod_ouv) ? header('location:' . PROJECT_ROM . 'membre/emprunter/'.$cod_ouv) : header('location:' . PROJECT_ROM . 'membre/emprunter/') ;
}
