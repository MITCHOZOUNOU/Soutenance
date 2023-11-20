<?php
require 'vendor/autoload.php';

define('PROJECT_ROM', '/romeo/update/soutenance/');

define('DATABASE_HOST','localhost');
define('DATABASE_NAME','bibliotheque');
define('DATABASE_USERNAME','root');
define('DATABASE_PASSWORD','');

define('MAIL_ADDRESS','bibiothequeparakou@gmail.com');
define('MAIL_PASSWORD','pzqtrqknpzhncfvv');


$default_profile = "membre";
$default_profile_folder = "app/membre/index.php";
$params = [];

if (isset($_GET['p']) && !empty($_GET['p'])) {
    $params = explode('/', $_GET['p']);
    $profile = (isset($params[0]) && !empty($params[0])) ? $params[0] : $default_profile;
    $profile_folder = "app/" . $profile . "/index.php";
    if (file_exists($profile_folder)) {
        include $profile_folder;
    } else {
        include $default_profile_folder;
    }
} else {
    include $default_profile_folder;
}
?>
