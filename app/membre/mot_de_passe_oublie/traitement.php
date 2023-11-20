<?php
$data = [];
$message_erreur_global = "";
$message_success_global = "";
$errors = [];

if (isset($_POST["email"]) && !empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $data["email"] = $_POST["email"];
} else {
    $errors["email"] = "Le champs email est requis. Veuillez le renseigné.";
}
$data["profil"] = "MEMBRE";

$data = $_SESSION['donnees_utilisateur'];

if (empty($errors)) {

    if (check_email_exist_in_bdd($_POST["email"])) {
        $token = uniqid("");
        $id_utilisateur = recuperer_id_utilisateur_par_son_mail($data['email']);

        if (!insertion_token($id_utilisateur, 'NOUVEAU_MOT_DE_PASSE', $token)) {
            $message_erreur_global = "La vérification de l'adresse mail s'est effectué avec succès mais une erreur est survenue lors de la génération de la clé de modification de mot de passe. Veuillez contacter un administrateur.";
        } else {
            $objet = 'Modification de mot de passe';
            ob_start(); // Démarre la temporisation de sortie
            include 'app/membre/mot_de_passe_oublie/message_mail.php'; // Inclut le fichier HTML dans le tampon
            $template_mail = ob_get_contents(); // Récupère le contenu du tampon
            ob_end_clean(); // Arrête et vide la temporisation de sortie

            if (send_email($data["email"], $objet, $template_mail)) {
                $data[] = $_POST["email"];
                //Création du cookie
                setcookie(
                    "mot_de_passe",
                    json_encode($data['email']),
                    [
                        'expires' => time() + 365 * 24 * 36000,
                        'path' => '/',
                        'secure' => 'true',
                        'httponly' => 'true',
                    ]
                );
                $message_success_global = "La vérification de l'adresse mail s'est effectuée avec succès. Veuillez consulter votre adresse mail afin de réinitialiser votre mot de passe.";
            } else {
                $message_erreur_global = "La vérification de l'adresse mail s'est effectuée avec succès mais une erreur est survenue lors de l'envoi du message mail. Veuillez contacter un administrateur.";
            }
        }
    } else {
        $message_erreur_global = "Oups ! Une erreur s'est produite lors de la vérification de l'adresse mail de l'utilisateur.";
    }
} elseif (!isset($errors['email'])) {
    $message_erreur_global = "Oups ! Une erreur s'est produite lors de la vérification de l'adresse mail de l'utilisateur.";
}

$_SESSION['errors'] = $errors;
$_SESSION['mot_passe_message_erreur_global'] = $message_erreur_global;
$_SESSION['mot_passe_message_success_global'] = $message_success_global;
header('location: ' . PROJECT_ROM . 'membre/mot_de_passe_oublie');


?>