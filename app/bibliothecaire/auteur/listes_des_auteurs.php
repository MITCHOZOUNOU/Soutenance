<?php

if(!empty($_SESSION ['utilisateur_connecter_bibliothecaire'])){
}else{
  header('location:'. PROJECT_ROM. 'bibliothecaire/dashboard/contact');
  exit;
}
$title = 'Liste des auteurs';
include './app/commun/header1.php';
$liste_auteur = get_liste_auteurs();
//die(var_dump)($liste_auteur);
?>


<section class="section dashboard">

	<main id="main" class="main">
		<div class="row">

		<!----message de succès global lors de l'ajout de l'auteur---->
		<?php
			if (isset($_SESSION['ajout-success']) && !empty($_SESSION['ajout-success'])) {
			?>
				<div class="alert alert-primary mt-3" style="color: white; background-color: #2bc717; text-align:center; border-radius: 15px; text-align:center;">
					<?= $_SESSION['ajout-success'] ?>
				</div>
			<?php
			}
			?>

			<!---message d'erreur global lorsque l'auteur existe déjà dans la base de donnée---->
			<?php
			if (isset($_SESSION['auteur-existe']) && !empty($_SESSION['auteur-existe'])) {
			?>
				<div class="alert alert-primary mt-3" style="color: white; background-color: #dc3545; border-radius: 15px; text-align:center;">
					<?= $_SESSION['auteur-existe'] ?>
				</div>
			<?php
			}
			?>

			<!----message de succès global lors de la modification de l'auteur---->
			<?php
			if (isset($_SESSION['modification_succès']) && !empty($_SESSION['modification_succès'])) {
			?>
				<div class="alert alert-primary mt-3" style="color: white; background-color: #2bc717; text-align:center; border-radius: 15px; text-align:center;">
					<?= $_SESSION['modification_succès'] ?>
				</div>
			<?php
			}
			?>
			<!---message de succès global lors de la suppression de l'auteur---->
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
			<!---message d'erreur global lors de la suppression de l'auteur---->
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
			<div class="col-md-6">
				<h1>Liste des auteurs</h1>
			</div>

			<div class="col-md-6 text-end bibliothèque-list-add-btn">
				<a href="<?= PROJECT_ROM ?>bibliothecaire/auteur/ajouter_des_auteurs" class="btn" style="background-color:black; color: white;">Ajouter un auteur</a>
			</div>

		</div>
		<div class="row mt-5">
			<?php
			if (!empty($liste_auteur)) {
			?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénoms</th>
							<th scope="col">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($liste_auteur as $key => $auteur) {
						?>
							<tr>
								<td><?php echo $auteur['nom_aut'] ?></td>
								<td><?php echo $auteur['prenoms_aut'] ?></td>
								<td>

									<a href="<?= PROJECT_ROM ?>bibliothecaire/auteur/modifier_des_auteurs/<?= $auteur['num_aut'] ?>" class="btn" style="background-color:black; color: white;">Modifier</a>
									<a href="#" class="btn" style="background-color:black; color: white;" data-bs-toggle="modal" data-bs-target="#cefp-ouvrage-supprimer-<?= $auteur['num_aut'] ?>">Supprimer</a>
								</td>
							</tr>
							
							<!-- Modal pour le bouton supprimer -->
							<div class="modal fade" id="cefp-ouvrage-supprimer-<?= $auteur['num_aut'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Supprimer l'auteur</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											Êtes-vous sûr de vouloir supprimer cet auteur ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
											<a href="<?= PROJECT_ROM ?>bibliothecaire/auteur/supprimer_traitement/<?= $auteur['num_aut'] ?>" class="btn btn-danger">Oui</a>
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
				echo 'Aucun auteur disponible pour le moment';
			}
			?>
		</div>
	</main>
</section>


</form>
<?php
unset($_SESSION['suppression_succes']);
unset($_SESSION['modification_succès']);
unset($_SESSION['ajout-success']);
unset($_SESSION['suppression_erreur']);
unset($_SESSION['auteur-existe']);

include './app/commun/footer1.php';

?>