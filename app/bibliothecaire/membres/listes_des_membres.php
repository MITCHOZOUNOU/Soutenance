<?php

if(!empty($_SESSION ['utilisateur_connecter_bibliothecaire'])){
}else{
  header('location:'. PROJECT_ROM. 'bibliothecaire/dashboard/index');
  exit;
}
$title = 'Listes des membres';
include './app/commun/header1.php';
$liste_membres = get_liste_membres();

?>

<section class="section dashboard">
	<main id="main" class="main">
		<div class="row">
		
			<div class="col-md-6">
				<h1>Liste des membres</h1>
			</div>

		</div>
		<div class="row mt-5">
			<?php if (!empty($liste_membres)) { ?>
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Nom</th>
							<th scope="col">Prénoms</th>
							<th scope="col">Actions</th>

						</tr>
					</thead>
					<tbody>
						<?php foreach ($liste_membres as $membre) { ?>
							<tr>
								<td><?= $membre['nom'] ?></td>
								<td><?= $membre['prenom'] ?></td>
								<td>
									<a href="#" class="btn btn-primary mb-3 btn-details" data-bs-toggle="modal" data-bs-target="#modal-details-<?= $membre['id'] ?>" data-id="<?= $membre['id'] ?>" data-email="<?= $membre['email'] ?>" data-adresse="<?= $membre['adresse'] ?>" data-sexe="<?= $membre['sexe'] ?>" data-date_naissance="<?= $membre['date_naissance'] ?>" data-telephone="<?= $membre['telephone'] ?>">Détails</a>

									<a href="#" class="btn btn-danger mb-3 btn-supprimer" data-bs-toggle="modal" data-bs-target="#modal-supprimer" data-id="<?= $membre['id'] ?>">Supprimer</a>
								</td>
							</tr>
							<!-- Modal pour le boutton details-->
							<div class="modal fade" id="modal-details-<?= $membre['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Détails sur le membre</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<p><strong>Email :</strong> <?= $membre['email'] ?></p>
											<p><strong>Adresse :</strong> <?= $membre['adresse'] ?></p>
											<p><strong>Sexe :</strong> <?= $membre['sexe'] ?></p>
											<p><strong>Date de naissance :</strong> <?= $membre['date_naissance'] ?></p>
											<p><strong>Téléphone :</strong> <?= $membre['telephone'] ?></p>
											<!-- Ajoutez d'autres informations du membre ici -->
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
										</div>
									</div>
								</div>
							</div>

							<!-- Modal pour le bouton supprimer-->
							<!-- Modal pour le bouton "Supprimer" -->
							<div class="modal fade" id="modal-supprimer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Supprimer le membre</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="modal-body">
											Êtes-vous sûr de vouloir supprimer ce membre ?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
											<button type="button" class="btn btn-danger" id="btn-confirmer-suppression">Oui</button>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</tbody>
				</table>
			<?php } else {
				echo 'Aucun membre disponible pour le moment';
			} ?>
		</div>
	</main>
</section>


<!-- ... -->

</script>

   
  <?php
include './app/commun/footer1.php';
?>
 