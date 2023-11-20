<?php

// Traitement de la suppression de l'auteur
if (isset($params['3']) && !empty($params['3']) && is_numeric($params['3'])) {
    $num_aut = $params['3'];

    // Appel de la fonction pour supprimer l'auteur
    $result = supprimer_auteur($num_aut);

    if ($result) {
        $_SESSION['suppression_succes'] = "L'auteur a été supprimé avec succès";
    } else {
        $_SESSION['suppression_erreur'] = "Erreur lors de la suppression de l'auteur";
    }

    // Redirection vers la liste des auteurs
    header('location:' . PROJECT_ROM . 'bibliothecaire/auteur/listes_des_auteurs');
    exit();
}

?>