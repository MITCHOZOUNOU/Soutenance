<?php
if (!empty($_SESSION["utilisateur_connecter_bibliothecaire"])) {
}else{
	header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
} 
$title = 'Modifier langues';
include './app/commun/header1.php';

if(isset($params['3']) && !empty($params['3']) && is_numeric($params['3'])){
	$cod_lang = $params['3'];
	$_SESSION['cod_lang']=$cod_lang;
	$langue = get_langue_by_id($cod_lang);

	}

?>

	<!-- =======================================================
	======================================================== -->
	<section class="section dashboard">
		<main id="main" class="main">
			<div class="row">

				<div class="col-md-6">
					<h1>Modifier la langue</h1>
				</div>

				<div class="col-md-6 text-end bibliotheque-list-add-btn">
					<a href="<?= PROJECT_ROM ?>bibliothecaire/langues/listes_des_langues" class="btn" style="background-color:black; color: white;">Liste des langues</a>
				</div>

			</div>

			<div class="row mt-5 ">

				<div class="col-md-12 col-lg-8 offset-lg-2 bd-example">

					<form action="<?= PROJECT_ROM ?>bibliothecaire/langues/traitement_modifier_langues" method="post">

					<div class="mb-3 row">
						<label for="libellé-langue" class="col-sm-2 col-form-label">Langue :</label>
						<div class="col-sm-7">
							<input type="text" class="form-control <?= isset($_SESSION['modifications_errors']) ? 'is-invalid' : '' ?>" id="libellé-langue" name="langue" placeholder="Veuillez entrer la langue" value="<?= isset($langue['lib_lang']) ? $langue['lib_lang'] : $data ?>">
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
				</div>
				<div class="row">
					<div class="col-sm-9 text-end mt-3">
						<button class="btn" style="background-color:black; color: white;"> Ajouter</button>
					</div>
				</div>
				</form>

			</div>

			</div>

		</main>
	</section>

<?php
include './app/commun/footer1.php';
?>

