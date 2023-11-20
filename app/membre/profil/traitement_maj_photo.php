<?php

$_SESSION['donnees-utilisateur'] = [];

$donnees = [];

$erreurs = [];

if (isset($_POST['change_photo'])) {

    if (check_password_exist(($_POST['password']), $_SESSION['utilisateur_connecter_membre']['id'])) {

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

            if ($_FILES["image"]["size"] <= 3000000) {

                $file_name = $_FILES["image"]["name"];

                $file_info = pathinfo($file_name);

                $file_ext = $file_info["extension"];

                $allowed_ext = ["png", "jpg", "jpeg", "gif"];

                if (in_array(strtolower($file_ext), $allowed_ext)) {

                    if (!is_dir("public/images/upload/")) {

                        mkdir("public/images/upload/");
                    }

                    move_uploaded_file($_FILES['image']['tmp_name'], 'public/images/upload/' . basename($_FILES['image']['name']));

                    $profiledonnees["image"] = PROJECT_ROM . 'public/images/upload/' . basename($_FILES['image']['name']);

                    if (mise_a_jour_avatar($_SESSION['utilisateur_connecter_membre']['id'], $profiledonnees["image"])) {

                    //       die(var_dump(recup_mettre_a_jour_informations_utilisateur($_SESSION['utilisateur_connecter_membre']['id'])));
                        if (recup_mettre_a_jour_informations_utilisateur($_SESSION['utilisateur_connecter_membre']['id'])) {
                            $_SESSION['utilisateur_connecter_membre']=recup_mettre_a_jour_informations_utilisateur($_SESSION['utilisateur_connecter_membre']['id']);
                            $_SESSION['global_membre_success'] = 'Photo de profil mise à jour avec succès.';
                            header('location:' . PROJECT_ROM . 'membre/profil');
                        }
                    }
                } else {
                    $_SESSION['global_membre_error'] = "L'extension de votre image n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";
                    header('location:' . PROJECT_ROM . 'membre/profil');
                }
            } else {
                $_SESSION['global_membre_error'] = "Image trop lourde. Poids maximum autorisé : 3mo";
                header('location:' . PROJECT_ROM . 'membre/profil');
            }
        } else {

            $profiledonnees["image"] = $donnees[0]["image_profil"];
        }
    } else {
        $_SESSION['global_membre_error'] = "La mise à jour à echouer. Vérifier votre mot de passe et réessayez.";
        header('location:' . PROJECT_ROM . 'membre/profil');
    }
}
