<?php

if(empty($_SESSION ['utilisateur_connecter_bibliothecaire'])){
  header('location:' . PROJECT_ROM . 'bibliothecaire/connexion/');
}
$title = 'Dashboard';
include("./app/commun/header1.php");
?>



<main>
        <h2>Tableau de bord</h2>
        <div class="dashboard">
          <div class="card">
            <h3>Livres enregistrés</h3>
            <p>245</p>
          </div>
          <div class="card">
            <h3>Emprunts en cours</h3>
            <p>14</p>
          </div>
          <div class="card">
            <h3>Livres populaires</h3>
          </div>
        </div>
      </main>
 


 <?php
include './app/commun/footer1.php';


?>