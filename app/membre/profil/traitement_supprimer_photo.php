<?php
$data = $_SESSION['utilisateur_connecter_membre'];

$_SESSION['photo-erreurs'] = "";
$_SESSION['photo_success'] = "";

if (isset($_POST['supprimer_photo'])) {
    // Vérifier si le mot de passe est correct avant de supprimer la photo
    $password_exist = check_password_exist($_POST['mot_de_passe'], $data['id']);
    
    if ($password_exist) {
        // Supprimer la photo de profil
        delete_avatar($data['id']);

        // Mettre à jour la session avec l'avatar mis à jour
        $_SESSION['utilisateur_connecter_membre']['avatar'] =  recup_update_avatar($data['id']);

        $_SESSION['global_membre_success'] = "Suppression de la photo réussie!";
        header('location:' . PROJECT_ROM . 'membre/profil');
    } else {
        $_SESSION['global_membre_error'] = "La suppression a échoué! Mot de passe incorrect!";
        header('location:' . PROJECT_ROM . 'membre/profil');
    }
} else {
    header('location:' . PROJECT_ROM . 'membre/profil');
}

