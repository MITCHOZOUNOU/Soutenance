<?php
session_start();
include 'app/commun/fonction.php';
$params = explode('/', $_GET['p']);
$profile = "bibliothecaire";
$default_ressource = "connexion";
$default_action = "index";
$default_action_folder = "app/" . $profile . "/" . $default_ressource . "/" . $default_action . ".php";

$emprunts = recup_emprunt_depuis_ouvrage_emprunt();

$date = date("Y-m-d H:i:s");

//die(var_dump($emprunts));

foreach($emprunts as $emprunt) {
    if (is_null($emprunt['date_effective_retour'])) {
        if (new DateTime($date) > new DateTime($emprunt['date_butoir_retour']) && !check_if_exist('membre_indelicat', 'num_mem', $emprunt['num_mem'])) {
            ajouter_membre_indelicat($emprunt['num_mem'], $emprunt['num_emp'], $emprunt['cod_ouv'], $emprunt['date_butoir_retour'], null, null);
        }
    }
}

if (isset($_GET['p']) && !empty($_GET['p'])) {
    $ressource = (isset($params[1]) && !empty($params[1])) ? $params[1] : $default_ressource;
    $action = (isset($params[2]) && !empty($params[2])) ? $params[2] : $default_action;
    $action_folder = "app/" . $profile . "/" . $ressource . "/" . $action . ".php";
    if (file_exists($action_folder)) {
        require_once $action_folder;
    } else {
        require_once $default_action_folder;
    }
} else {
    require_once $default_action_folder;
}

?>