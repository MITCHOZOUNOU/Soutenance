<?php

    unset($_SESSION["utilisateur_connecter_bibliothecaire"]);
    if(!isset ($_SESSION["utilisateur_connecter_bibliothecaire"])){ 
        header('location: '. PROJECT_ROM .'bibliothecaire/connexion');
    }
?>
