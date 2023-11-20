<?php

if(!empty($_SESSION ['utilisateur_connecter_bibliothecaire'])){
  $title = 'Aide';
include 'app/commun/header1.php'

?>
 


 <?php
include 'app/commun/footer1.php';
}else{
    header('location:  '. PROJECT_ROM. 'bibliothecaire/connexion/index');
  }?>