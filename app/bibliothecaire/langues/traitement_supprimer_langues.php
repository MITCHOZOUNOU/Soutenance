<?php

// Traitement de la suppression de la langue
if (isset($params['3']) && !empty($params['3']) && is_numeric($params['3'])) {
    $cod_lang = $params['3'];

    // Appel de la fonction pour supprimer la langue
    $result = supprimer_langue($cod_lang);

    if ($result) {
        $_SESSION['suppression_succes'] = "La langue a été supprimée! ";
    } else {
        $_SESSION['suppression_erreur'] = "Une erreur est survenue lors de la suppression. Veuillez réessayer.";
    }

    // Redirection vers la liste des langues
    header('location:' . PROJECT_ROM . 'bibliothecaire/langues/listes_des_langues');
    exit();
}

?>