<?php

$_SESSION['ajout_ouvrage_errors'] = [];
$_SESSION['global_bibliothecaire_error'] = [];
$_SESSION['global_bibliothecaire_success'] = [];
$_SESSION['data'] = [];
$errors = [];
$data = [];

if (!empty($_POST['titre_ouvrage'])) {

    $titre_ouvrage = $_POST['titre_ouvrage'];
    $data['titre_ouvrage'] = $_POST['titre_ouvrage'];
} else {
    $_SESSION['ajout_ouvrage_errors']['titre_ouvrage'] = 'Champs requis.';
}

if (!empty($_POST['nombre_exemplaire_ouvrage'])) {

    $nombre_exemplaire_ouvrage = $_POST['nombre_exemplaire_ouvrage'];
    $data['nombre_exemplaire_ouvrage'] = $_POST['nombre_exemplaire_ouvrage'];
} else {
    $_SESSION['ajout_ouvrage_errors']['nombre_exemplaire_ouvrage'] = 'Champs requis.';
}

if (!empty($_POST['auteur_principal_ouvrage']) && $_POST['auteur_principal_ouvrage'] != 0) {

    if (check_if_exist('auteur', 'num_aut', $_POST['auteur_principal_ouvrage'])) {
        $auteur_principal_ouvrage = $_POST['auteur_principal_ouvrage'];
        $data['auteur_principal_ouvrage'] = $_POST['auteur_principal_ouvrage'];
    } else {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Auteur principal bloque le processus.';
    }

} else {
    $_SESSION['ajout_ouvrage_errors']['auteur_principal_ouvrage'] = 'Champs requis.';
}

if (!empty($_POST['annee_publication'])) {

    $annee_publication = $_POST['annee_publication'];
    $data['annee_publication'] = $_POST['annee_publication'];
} else {
    $_SESSION['ajout_ouvrage_errors']['annee_publication'] = 'Champs requis.';
}

if (!empty($_FILES['image_ouvrage'])) {
    if (isset($_FILES["image_ouvrage"]) && $_FILES["image_ouvrage"]["error"] == 0) {

        if ($_FILES["image_ouvrage"]["size"] <= 3000000) {

            $file_name = $_FILES["image_ouvrage"]["name"];

            $file_info = pathinfo($file_name);

            $file_ext = $file_info["extension"];

            $allowed_ext = ["png", "jpg", "jpeg", "gif", "webp"];

            if (in_array(strtolower($file_ext), $allowed_ext)) {

                if (!is_dir("public/images/upload/ouvrage/")) {

                    mkdir("public/images/upload/ouvrage/");
                }

                move_uploaded_file($_FILES['image_ouvrage']['tmp_name'], 'public/images/upload/ouvrage/' . basename($_FILES['image_ouvrage']['name']));

                $image_ouvrage = PROJECT_ROM . 'public/images/upload/ouvrage/' . basename($_FILES['image_ouvrage']['name']);
            } else {
                $_SESSION['ajout_ouvrage_errors']['image_ouvrage'] = "L'extension de votre image n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
            }
        } else {

            $_SESSION['ajout_ouvrage_errors']['image_ouvrage'] = "Image trop lourde. Poids maximum autorisé : 3mo";
        }
    } else {
        $_SESSION['ajout_ouvrage_errors']['image_ouvrage'] = "Une erreur est survenue lors du téléchargement de l'image.";
    }
} else {
    $_SESSION['ajout_ouvrage_errors']['image_ouvrage'] = 'Champs requis.';
}

if (empty($_POST['langue_ouvrage']) || $_POST['langue_ouvrage'] == 0) {

    $_SESSION['ajout_ouvrage_errors']['langue_ouvrage'] = 'Champs requis.';
} elseif (!empty($_POST['langue_ouvrage']) && $_POST['langue_ouvrage'] != 0) {

    if (check_if_exist('langue', 'cod_lang', $_POST['langue_ouvrage'])) {
        $langue_ouvrage = $_POST['langue_ouvrage'];
        $data['langue_ouvrage'] = $_POST['langue_ouvrage'];
    } else {
        if (empty($_SESSION['global_bibliothecaire_error'])) {
            $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Langue bloque le processus.';
        }
    }
}

if (!empty($_POST['auteurs_secondaires_ouvrage']) && is_array($_POST['auteurs_secondaires_ouvrage'])) {

    if (!empty($_POST['auteurs_secondaires_ouvrage']) && $_POST['auteurs_secondaires_ouvrage'][0] != 0) {

        foreach ($_POST['auteurs_secondaires_ouvrage'] as $key => $auteur_secondaire) {

            if (check_if_exist('auteur', 'num_aut', $auteur_secondaire)) {

                $data['auteurs_secondaires_ouvrage'][] = $auteur_secondaire;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Auteurs Secondaires bloque le processus.';
                }
            }
        }
    } 

} elseif (!empty($_POST['auteurs_secondaires_ouvrage']) && !is_array($_POST['auteurs_secondaires_ouvrage'])) {
    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Auteurs Secondaires bloque le processus.';
    }
}

if (is_array($_POST['domaine_ouvrage'])) {

    if (!empty($_POST['domaine_ouvrage']) && $_POST['domaine_ouvrage'][0] != 0) {

        foreach ($_POST['domaine_ouvrage'] as $key => $dom) {
            if (check_if_exist('domaine', 'cod_dom', $dom)) {
                $data['domaine_ouvrage'][] = $dom;
            } else {
                if (empty($_SESSION['global_bibliothecaire_error'])) {
                    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Domaines bloque le processus.';
                }
            }
        }
    } else {
        $_SESSION['ajout_ouvrage_errors']['domaine_ouvrage'] = 'Champs requis.';
    }
} else {
    if (empty($_SESSION['global_bibliothecaire_error'])) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue au niveau du champs Domaines bloque le processus.';
    }
}

$errors = $_SESSION['ajout_ouvrage_errors'];

if (empty($errors) && empty($_SESSION['global_bibliothecaire_error'])) {

    $ouvrage_enregistrer = ajout_ouvrage_recup_id(strtoupper($titre_ouvrage), intval(abs($nombre_exemplaire_ouvrage)), intval(abs($annee_publication)), $auteur_principal_ouvrage, $image_ouvrage)[0];

    assoc_ouvrage_lang_an_pub($ouvrage_enregistrer, $langue_ouvrage, $annee_publication);

    if (!empty($_POST['auteurs_secondaires_ouvrage'])) {
        foreach ($_POST['auteurs_secondaires_ouvrage'] as $key => $auteur_secondaire) {
            assoc_ouvrage_aut_secondaires($ouvrage_enregistrer, $auteur_secondaire);
        }
    }

    foreach ($_POST['domaine_ouvrage'] as $key => $dom) {
        assoc_ouvrage_domaine($ouvrage_enregistrer, $dom);
    }

    if (empty($_POST['more'])) {

        $_SESSION['global_bibliothecaire_success'] = 'Ouvrage(s) ajouté(s) avec succès.';
        header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/listes_ouvrages');
    } elseif (!empty($_POST['more'])) {

        $_SESSION['global_bibliothecaire_success'] = 'Précédent(s) ouvrage(s) ajouté(s) avec succès.';
        header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/ajouter_ouvrages');
    }
} else {

    if (!empty($_POST['more'])) {
        $data['more'] = $_POST['more'];
    }

    $_SESSION['data'] = $data;
    $_SESSION['global_bibliothecaire_error'] = 'Des erreurs sont survenues. Vérifiez vos saisies et réessayer.';

    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/ajouter_ouvrages');
}
