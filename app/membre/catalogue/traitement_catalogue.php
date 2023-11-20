<?php

if (!empty($_POST['search'])) {

    if (!empty($_POST['titre_ouvrage'])) {
        $_SESSION['titre'] = $_POST['titre_ouvrage'];
    }

    if (!empty($_POST['cod_dom'])) {
        $_SESSION['domaine'] = $_POST['cod_dom'];
    }

    header('location:' . PROJECT_ROM . 'membre/catalogue/index');
}


