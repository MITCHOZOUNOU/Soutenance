<?php
if (!empty($_SESSION ['utilisateur_connecter_membre'])) {
	header('location:' . PROJECT_ROM . 'membre/accueil');
}
$title = 'Mot de passe oublie';
include 'app/commun/header_membre.php';
?>

<main>
	<div class="container">

		<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
			<div class="container">
				<div class="row justify-content-center">
					<div class=" col-md-6 d-flex flex-column align-items-center justify-content-center">

						<div class="card mb-3">

							<div class="card-body">
							<!----message de succès global lors du processus d'envoi de mail pour un changement de mot de passe----->
							<?php
								if (isset($_SESSION['mot_passe_message_success_global']) && !empty($_SESSION['mot_passe_message_success_global'])) {
								?>
									<div class="alert alert-primary mt-3" style="color: white; background-color: #2bc717; text-align:center; border:5px; text-align:center;">
										<?= $_SESSION['mot_passe_message_success_global'] ?>
									</div>
								<?php
								}
								?>
								<!----message d'erreur global lors du processus d'envoi de mail pour un changement de mot de passe----->
								<?php
								if (isset($_SESSION['mot_passe_message_erreur_global']) && !empty($_SESSION['mot_passe_message_erreur_global'])) {
								?>
									<div class="alert alert-primary mt-3" style="color: white; background-color: #dc3545; border: 5px; text-align:center;">
										<?= $_SESSION['mot_passe_message_erreur_global'] ?>
									</div>
								<?php
								}

								?>

                               <?php

								if (isset($_SESSION['validation-compte-message-erreur']) && !empty($_SESSION['validation-compte-message-erreur'])) {
								?>
									<div class="alert alert-primary mt-3" style="color: white; background-color: #dc3545; border: 5px; text-align:center;">
										<?= $_SESSION['validation-compte-message-erreur'] ?>
									</div>
								<?php
								}

								?>

								<div class="pt-4 pb-2">
								<h3 class="">Aviez-vous oublier votre mot de passe?</h3>
								<p class="text-medium-emphasis">Veuillez entrer votre e-mail afin de recevoir un message pour reinitialiser votre mot de passe</p>
								</div>
								
                
								<form class="row needs-validation" action="<?= PROJECT_ROM ?>membre/mot_de_passe_oublie/traitement" method="post" novalidate>
									<div class="col-12 mt-3">
                        <label for="nom_utilisateur" class="form-label">Adresse mail
                          <span class="text-danger">(*)</span>
                        </label>
                    <input type="email" class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>" name="email" value="<?php if (isset($data["email"]) && !empty($data["email"])) {
																																														echo $data["email"];
																																													} else {
																																														echo '';
																																													} ?>" id="email" placeholder="Veuillez entrer votre adresse email">
										<?php
										if (isset($_SESSION['errors']['email'])) {
										?>
											<div class="invalid-feedback">
												<?= $_SESSION['errors']['email'] ?>
											</div>
										<?php
										}
										?>
									</div>

                  <div class="row mt-3 mb-3">
									<div class="col-6">
										<button class="btn btn-danger w-100 text-white" type="reset">Annuler</button>
									</div>

									<div class="col-6">
										<button class="btn btn-primary w-100" type="submit">Envoyer</button>
									</div>
                  </div>
                  
									<div class="row mt-3 mb-3">
										<div class="col-6 w-100">
											<a href="<?= PROJECT_ROM ?>membre/connexion">Connexion</a>
										</div>

									</div>


								</form>

							</div>
						</div>
					</div>
				</div>
			</div>

		</section>

	</div>
</main>
<!-- End #main -->
<?php
include 'app/commun/footer_membre.php';
unset($_SESSION['validation-compte-message-erreur']);
unset($_SESSION['errors'], $_SESSION['mot_passe_message_erreur_global'], $_SESSION['mot_passe_message_success_global']);
?>