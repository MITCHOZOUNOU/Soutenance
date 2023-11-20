<?php
    unset($_SESSION["utilisateur_connecter_membre"]);
    if(!isset ($_SESSION["utilisateur_connecter_membre"])){
        header('location: '. PROJECT_ROM .'membre/accueil/');
    }
?>
