<?php
$url = $_SERVER["REQUEST_SCHEME"] . '://' . $_SERVER["HTTP_HOST"] . PROJECT_ROM . 'bibliothecaire/reinitialiser_mot_de_passe/index/{id_utilisateur}/{token}';

$url = str_replace('{id_utilisateur}', $id_utilisateur, $url);

$url = str_replace('{token}', $token, $url);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.gstatic.com" rel="preconnect">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <title>Email de gestion de bibliothèque</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #ffffff;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #DDDDDD;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #DDDDDD;
        }

        h1 {
            font-size: 24px;
            margin: 0;
            color: #012970;
            font-family: "Nunito", sans-serif;
        }

        h2 {
            font-size: 19px;
            color:#012970;
            font-family: "Poppins" , sans-serif;

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
            background-color: #0d6efd;
            color: #ffffff;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            width: 30%;
            text-align: center;
            
        }

        .button:hover {
            background-color: #0b5ed7;
            color: #ffffff;
            border: 1px solid #0a58ca;
        }
    </style>
</head>

<body>
    <div class="container" style="background-color: #f6f9ff; display: flex; justify-content: center; align-items: center;">
        <div>
            <h1> BIBLIOTHEQUE DE PARAKOU<br></h1>
        <h2>Réinitialisation de mot de passe</h2>
        </div>

    </div>
    <div class="container">
        
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