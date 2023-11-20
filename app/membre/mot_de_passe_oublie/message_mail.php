<?php
$url = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . PROJECT_ROM . 'membre/reinitialiser_mot_de_passe/index/{id_utilisateur}/{token}';

$url = str_replace('{id_utilisateur}', $id_utilisateur, $url);

$url = str_replace('{token}', $token, $url);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email de gestion de la Bibiothèque de Parakou
</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F5F5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
            border: 1px solid #DDDDDD;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #DDDDDD;
        }
        h1 {
            font-size: 24px;
            margin: 0;
            color: #444444;
        }
        p {
            font-size: 16px;
            margin-top: 10px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1E90FF;
            color: #012970;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .button:hover {
            background-color: #f6f9ff;
            color: #1E90FF;
            border: 1px solid #1E90FF;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BIBLIOTHEQUE DE PARAKOU</h1>
        <p>Nous avons reçu votre demande de réinitialisation de mot de passe.
            Afin de pouvoir modifier votre mot de passe ,
            veuillez cliquer sur le bouton ci-bas.</p>
        <p>Une fois que vous auriez cliqué sur le bouton, vous pourriez créer un nouveau mot de passe afin d'avoir accès à votre compte.</p>
        <p>Si vous rencontrez des difficultés au cours du processus, n'hésitez pas à nous contacter.</p>
        <p>Cordialement, l'équipe de la "Bibliothèque de Parakou"</p>
        <a href="<?= $url ?>" class="button">Réinitialiser</a>
    </div>
</body>
</html>
