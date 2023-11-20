<?php
$url = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . PROJECT_ROM . 'membre/inscription/confirmation/{id_utilisateur}/{token}';

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
        <h1>BIENVENUE</h1>
        <p>Merci de vous êtes inscrit dans notre Bibiothèque</p>
        <p>Merci de cliquer sur le bouton afin de valider votre inscription.</p>
        <p>Cordialement,</p>
        <p>L'équipe de la Bibiothèque de Parakou
</p>
<a href="<?= $url ?>" class="button">Valider</a>
    </div>
</body>
</html>
