<?php
if (empty($_SESSION["utilisateur_connecter_bibliothecaire"])) {
	header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
}
$title = 'Modifier auteur';
include './app/commun/header1.php';

if(isset($params['3']) && !empty($params['3']) && is_numeric($params['3'])){
	$num_aut = $params['3'];
	$_SESSION['num_aut']=$num_aut;
	$auteur = get_auteur_by_id($num_aut);
	if (!empty($auteur)) {
		$nom_aut = $auteur['nom_aut'];
		$prenoms_aut = $auteur['prenoms_aut'];
	}
}
?>

<section class="section dashboard">
	<main id="main" class="main">
		<div class="row">
			<div class="col-md-6">
				<h1>Modifier l'auteur</h1>
			</div>

			<div class="col-md-6 text-end cefp-list-add-btn">
				<a href="<?= PROJECT_ROM ?>bibliothecaire/auteur/listes_des_auteurs" class="btn" style="background-color:black; color: white;">Liste des auteurs</a>
			</div>

		</div>

		<div class="row mt-5 ">

			<div class="col-md-12 col-lg-8 offset-lg-2 bd-example">

				<form action="<?= PROJECT_ROM ?>bibliothecaire/auteur/traitement_modifier_auteurs" method="post">

					<div class="mb-3 row">
						<label for="nom-auteur" class="col-sm-2 col-form-label">Nom:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control <?= isset($_SESSION['modification_errors']['nom_aut']) ? 'is-invalid' : '' ?>" id="nom-auteur" name="nom_aut" value="<?= isset($nom_aut) ? $nom_aut : '' ?><?= isset($_SESSION['nom_aut']) ? $_SESSION['nom_aut'] : '' ?>">
							<?php
								unset($_SESSION['nom_aut']);
								?>
							<?php
							if (isset($_SESSION['modification_errors']['nom_aut'])) {
							?>
								<div class="invalid-feedback">
									<?= $_SESSION['modification_errors']['nom_aut'] ?>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<div class="mb-3 row">
						<label for="prenom-auteur" class="col-sm-2 col-form-label">Prénoms:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control <?= isset($_SESSION['modification_errors']['prenoms_aut']) ? 'is-invalid' : '' ?>" id="prenom-auteur" name="prenoms_aut" value="<?= isset($prenoms_aut) ? $prenoms_aut : '' ?><?= isset($_SESSION['prenoms_aut']) ? $_SESSION['prenoms_aut'] : '' ?>">
							<?php
								unset($_SESSION['prenoms_aut']);
								?>
							<?php
							if (isset($_SESSION['modification_errors']['prenoms_aut'])) {
							?>
								<div class="invalid-feedback">
									<?= $_SESSION['modification_errors']['prenoms_aut'] ?>
								</div>
							<?php
							}
							?>
						</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10 text-end mt-3">
							<button class="btn" style="background-color:black; color: white;"> Ajouter</button>
						</div>
					</div>
			</div>
			</form>
		</div>

		</div>

	</main>
</section>

<?php
include './app/commun/footer1.php';
unset($_SESSION['modification_errors']);
?>