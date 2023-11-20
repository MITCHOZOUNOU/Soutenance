<?php
if (empty($_SESSION["utilisateur_connecter_bibliothecaire"])) {
	header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
	exit;
}

$title = 'Modifier un domaine';
include './app/commun/header1.php';

if (isset($params['3']) && !empty($params['3']) && is_numeric($params['3'])) {
	$cod_dom = $params['3'];
	$_SESSION['cod_dom'] = $cod_dom;
	$domaine = get_domaine_by_id($cod_dom);
}
?>

<section class="section dashboard">
	<main id="main" class="main">
		<div class="row">
			<div class="col-md-6">
				<h1>Modifier le domaine</h1>
			</div>

			<div class="col-md-6 text-end cefp-list-add-btn">
				<a href="<?= PROJECT_ROM ?>bibliothecaire/domaines/listes_domaines" class="btn" style="background-color:black; color: white;">Liste des domaines</a>
			</div>
		</div>

		<div class="row mt-5">

			<div class="col-md-12 col-lg-8 offset-lg-2 bd-example">

				<form action="<?= PROJECT_ROM ?>bibliothecaire/domaines/traitement_modifier_domaines" method="post">

					<div class="mb-3 row">
						<label for="libellé-domaine" class="col-sm-2 col-form-label">Domaine:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control <?= isset($_SESSION['modifications_errors']) ? 'is-invalid' : '' ?>" id="libellé-domaine" name="domaine" placeholder="Veuillez entrer le domaine" value="<?= isset($domaine['lib_dom']) ? $domaine['lib_dom'] : $data ?>">
							<?php
							if (isset($_SESSION['modifications_errors'])) {
							?>
								<div class="invalid-feedback">
									<?= $_SESSION['modifications_errors'] ?>
								</div>
							<?php
							}
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 text-end mt-3">
							<button class="btn" style="background-color:black; color: white;">Modifier</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</main>
</section>

<?php
unset($_SESSION['modifications_errors']);
include './app/commun/footer1.php';
?>
