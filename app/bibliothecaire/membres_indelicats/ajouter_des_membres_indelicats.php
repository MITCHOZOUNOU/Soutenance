<?php


if(!empty($_SESSION ['utilisateur_connecter_bibliothecaire'])){
}else{
  header('location:'. PROJECT_ROM. 'bibliothecaire/dashboard/index');
  exit;
}
$title = 'Ajouter membre indelicats';
include './app/commun/header1.php'

?>



<?php
include './app/commun/footer1.php';
?>