<?php
if (!empty($_SESSION['utilisateur_connecter_bibliothecaire'])) {
} else {
  header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
  exit;
}

$title = 'Listes des domaines';
include './app/commun/header1.php';

$liste_domaine = get_liste_domaine(); // Assurez-vous que la fonction get_liste_domaine() récupère correctement la liste des domaines depuis la base de données.
?>

<section class="section dashboard">
  <main id="main" class="main">
    <div class="row">
				<!---message d'erreur global lorsque l'auteur existe déjà dans la base de donnée---->
				<?php
			if (isset($_SESSION['domaine-existe']) && !empty($_SESSION['domaine-existe'])) {
			?>
				<div class="alert alert-primary mt-3" style="color: white; background-color: #dc3545; border-radius: 15px; text-align:center;">
					<?= $_SESSION['domaine-existe'] ?>
				</div>
			<?php
			}
			?>
      <!---message de succès global lors de la modification du domaine---->
      <?php
      if (isset($_SESSION['modification_succès']) && !empty($_SESSION['modification_succès'])) {
      ?>
        <div class="alert alert-primary mt-3" style="color: white; background-color: #2bc717; text-align:center; border-radius: 15px; text-align:center;">
          <?= $_SESSION['modification_succès'] ?>
        </div>
      <?php
      }
      ?>
      <!---message de succès global lors de la suppression du domaine---->
      <?php
      if (isset($_SESSION['suppression_succes']) && !empty($_SESSION['suppression_succes'])) {
      ?>
        <div class="alert alert-primary mt-3" style="color: white; background-color: #2bc717; text-align:center; border-radius: 15px; text-align:center;">
          <?= $_SESSION['suppression_succes'] ?>
        </div>
      <?php
        unset($_SESSION['suppression_succes']);
      }
      ?>
      <!---message d'erreur global lors de la suppression du domaine---->
      <?php
      if (isset($_SESSION['suppression_erreur']) && !empty($_SESSION['suppression_erreur'])) {
      ?>
        <div class="alert alert-primary mt-3" style="color: white; background-color: #dc3545; text-align:center; border-radius: 15px; text-align:center;">
          <?= $_SESSION['suppression_erreur'] ?>
        </div>
      <?php
        unset($_SESSION['suppression_erreur']);
      }
      ?>
	  	<!----message de succès global lors de l'ajout du domaines---->
		  <?php
			if (isset($_SESSION['ajout-success']) && !empty($_SESSION['ajout-success'])) {
			?>
				<div class="alert alert-primary mt-3" style="color: white; background-color: #2bc717; text-align:center; border-radius: 15px; text-align:center;">
					<?= $_SESSION['ajout-success'] ?>
				</div>
			<?php
			}
			?>
      <!-- =======================================================
      ========================================================= -->
      <div class="col-md-6">
        <h1>Liste des domaines</h1>
      </div>

      <div class="col-md-6 text-end cefp-list-add-btn">
        <a href="<?= PROJECT_ROM ?>bibliothecaire/domaines/ajouter_domaines" class="btn" style="background-color:black; color: white;">Ajouter un domaine</a>
      </div>
    </div>

    <div class="row mt-5">
      <?php
      if (!empty($liste_domaine)) {
      ?>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="coi">Domaine</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($liste_domaine as $key => $domaine) {
            ?>
              <tr>
                <td><?php echo $domaine['lib_dom'] ?></td>
                <td>
                  <a href="<?= PROJECT_ROM ?>bibliothecaire/domaines/modifier_domaines/<?= $domaine['cod_dom'] ?>" class="btn"  style="background-color:black; color: white;">Modifier</a>
                  <a href="#" class="btn"  style="background-color:black; color: white;" data-bs-toggle="modal" data-bs-target="#cefp-ouvrage-supprimer-<?= $domaine['cod_dom'] ?>">Supprimer</a>
                </td>
              </tr>
              <!-- Modal pour le bouton supprimer-->
              <div class="modal fade" id="cefp-ouvrage-supprimer-<?= $domaine['cod_dom'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Supprimer le domaine</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Etes vous sur de vouloir supprimer ce domaine ?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                      <a href="<?= PROJECT_ROM ?>bibliothecaire/domaines/traitement_supprimer_domaines/<?= $domaine['cod_dom'] ?>" class="btn btn-danger">Oui</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
          </tbody>
        </table>
      <?php
      } else {
        echo 'Aucun domaine disponible pour le moment';
      }
      ?>
    </div>
  </main>
</section>

<?php
unset($_SESSION['modification_succès']);
unset($_SESSION['ajout-success']);
unset($_SESSION['domaine-existe']);


include './app/commun/footer1.php';
?>
