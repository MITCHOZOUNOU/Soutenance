<?php
if(!empty($_SESSION ['utilisateur_connecter_bibliothecaire'])){
}else{
  header('location:'. PROJECT_ROM. 'bibliothecaire/dashboard/index');
  exit;
}

if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
  }
  
  
  if (isset($_SESSION['data']) && !empty($_SESSION['data'])) {
    $data = $_SESSION['data'];
    }
	$title = 'Ajouter un domaine';
include './app/commun/header1.php'

?>

<section class="section dashboard">
		<main id="main" class="main">
			<div class="row">
				<!---message d'erreur global lors de l'ajout du domaines---->
			<?php
			if (isset($_SESSION['ajout-errors']) && !empty($_SESSION['ajout-errors'])) {
			?>
				<div class="alert alert-primary mt-3" style="color: white; background-color: #dc3545; border-radius: 15px; text-align:center;">
					<?= $_SESSION['ajout-errors'] ?>
				</div>
			<?php
			}
			?>
		
				<div class="col-md-6">
					<h1>Ajouter un domaines</h1>
				</div>

				<div class="col-md-6 text-end cefp-list-add-btn">
					<a href="<?= PROJECT_ROM ?>bibliothecaire/domaines/listes_domaines" class="btn" style="background-color:black; color: white;">Liste des domaines</a>
				</div>
			</div>

			<div class="row mt-5">

				<div class="col-md-12 col-lg-8 offset-lg-2 bd-example">

					<form action="<?= PROJECT_ROM ?>bibliothecaire/domaines/traitement_ajoutes_domaines" method="post">
						
						<div class="mb-3 row">
							<label for="libellé-domaines" class="col-sm-2 col-form-label">Domaines:</label>
							<div class="col-sm-7">
								<input type="text" class="form-control <?= isset($_SESSION['ajouter-domaines-errors']) ? 'is-invalid' : '' ?>" id="libellé-domaines" name="domaines" placeholder="Veuillez entrer le domaines">
								<?php
							if (isset($_SESSION['ajouter-domaines-errors'])) {
							?>
								<div class="invalid-feedback">
									<?= $_SESSION['ajouter-domaines-errors'] ?>
								</div>
							<?php
							}
							?>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-20 text-center mt-3">
								<button class="btn" style="background-color:black; color: white;"> Ajouter</button>
							</div>
						</div>
					</form>
				</div>

			</div>
		</main>
	</section>


<?php
unset($_SESSION['ajouter-domaines-errors']);
unset($_SESSION['message-erreur-global']);
unset($_SESSION['domaine-existe']);

include './app/commun/footer1.php';
?>

    