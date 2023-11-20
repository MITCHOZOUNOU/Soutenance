<?php
$data = $_SESSION['utilisateur_connecter_bibliothecaire'];

$_SESSION['photo-erreurs'] = "";
$_SESSION['photo_success'] = "";

if (isset($_POST['supprimer_photo'])) {
    // Vérifier si le mot de passe est correct avant de supprimer la photo
    $password_exist = check_password_exist($_POST['mot_de_passe'], $data['id']);
    
    if ($password_exist) {
        // Supprimer la photo de profil
        delete_avatar($data['id']);

        // Mettre à jour la session avec l'avatar mis à jour
        $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] =  recup_update_avatar($data['id']);

        $_SESSION['photo_success'] = "Suppression de la photo réussie!";
        header('location:' . PROJECT_ROM . 'bibliothecaire/mon_profil/profil');
        exit();
    } else {
        $_SESSION['photo-erreurs'] = "La suppression a échoué! Mot de passe incorrect!";
        header('location:' . PROJECT_ROM . 'bibliothecaire/mon_profil/profil');
        exit();
    }
} else {
    header('location:' . PROJECT_ROM . 'bibliothecaire/mon_profil/profil');
    exit();
}
?>
