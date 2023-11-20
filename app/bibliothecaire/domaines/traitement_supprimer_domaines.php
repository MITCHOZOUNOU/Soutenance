<?php
$domaine = [];
$errors = "";


// Traitement de la suppression de domaines
if (isset($params['3']) && !empty($params['3']) && is_numeric($params['3'])) {
    $cod_dom = $params['3'];

    // Appel de la fonction pour supprimer domaine
    $result = supprimer_domaine($cod_dom);

    if ($result) {
        $_SESSION['suppression_succes'] = "Le domaine a été supprimée! ";
    } else {
        $_SESSION['suppression_erreur'] = "Une erreur est survenue lors de la suppression. Veuillez réessayer.";
    }

    // Redirection vers la liste des domaines
    header('location:' . PROJECT_ROM . 'bibliothecaire/domaines/listes_domaines');
    exit();
}

?>