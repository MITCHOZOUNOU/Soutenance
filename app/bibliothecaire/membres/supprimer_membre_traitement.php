<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $idMembreASupprimer = $_POST['id'];

    // Appeler la fonction pour supprimer le compte du membre
    $suppressionReussie = supprimer_utilisateur($idMembreASupprimer);

    // Envoyer une réponse au JavaScript pour indiquer si la suppression a réussi ou échoué
    if ($suppressionReussie) {
        // Définir le cookie avec le message d'alerte
        $message = "Votre compte a été supprimé par le bibliothécaire.";
        setcookie("compte_supprime_message", $message, time() + 3600, "/"); // Le cookie expire dans 1 heure (3600 secondes)

        echo json_encode(['status' => 'success']);
    } else {
        $erreurMessage = 'Une erreur s\'est produite lors de la suppression. Veuillez réessayer.';
        echo json_encode(['status' => 'error', 'message' => $erreurMessage]);
    }
}

?>