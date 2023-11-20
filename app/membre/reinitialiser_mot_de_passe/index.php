<?php
if (!empty($_SESSION ['utilisateur_connecter_membre'])) {
    header('location:' . PROJECT_ROM . 'membre/accueil');
}
$title = 'Reinitiqliser mot de passe';
include 'app/commun/header_membre.php'; //die(var_dump($params[3]));
$_SESSION['id_user'] = $params[3];

?>
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class=" col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <a class="navbar-brand" href="#">
                    <img src="<?= PROJECT_ROM ?>public/images/logo.png" style="width: 500px;" class="img-fluid" alt="Logo">
                    </a>
                       <div class="card mb-3">
                        
                            <div class="card-body">
                      
                             <?php
								if (isset($_SESSION['save_errors']) && !empty($_SESSION['save_errors'])) {
									?>
									<div class="alert alert-danger mt-3"
										 style="color: white; background-color: #dc3545; border: 5px; text-align: center;">
										<?= $_SESSION['save_errors'] ?>
									</div>
									<?php
								}
								?>

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Réinitialiser mot de passe</h5>

                                </div>

                                <form class="row needs-validation" action="<?= PROJECT_ROM ?>membre/reinitialiser_mot_de_passe/traitement" method="post">

                                    <div class="col-12 mt-3">
                                    <label for="reinitialiser_mot_de_passe" class="form-label">
										Mot de passe
										<span class="text-danger"> (*)</span>
										:
									</label>
									<input type="password" id="reinitialiser_mot_de_passe"
										   class="form-control <?= isset($_SESSION['errors']['mot_de_passe']) ? 'is-invalid' : '' ?>"
										   name="mot_de_passe" placeholder=" Veuillez entrer un mot de passe"
										   value="">
									<?php if (isset($_SESSION['errors']['mot_de_passe']) && !empty($_SESSION['errors']['mot_de_passe'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['mot_de_passe'] ?>
										</div>
									<?php } ?>                                                                                                                                                       
                                        <!---<div class="invalid-feedback">Enter une adresse e-mail valide s'il vous plaît!</div>---->
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label for="confirmer_mot_de_passe" class="form-label">Confirmer mot de passe</label>
                                        <input type="password" class="form-control <?= isset($_SESSION['errors']['confirmer_mot_de_passe']) ? 'is-invalid' : '' ?>" name="confirmer_mot_de_passe" value="<?php if (isset($data["confirmer_mot_de_passe"]) && !empty($data["confirmer_mot_de_passe"])) {
																																																							echo $data["confirmer_mot_de_passe"];
																																																						} else {
																																																							echo '';
																																																						} ?>" id="confirmer_mot_de_passe" placeholder="Veuillez confirmer le mot de passe">
										<?php
										if (isset($_SESSION['errors']['confirmer_mot_de_passe'])) {
										?>
											<div class="invalid-feedback">
												<?= $_SESSION['errors']['confirmer_mot_de_passe'] ?>
											</div>
										<?php
										}
										?>
                                    </div>

									<div class="row mt-3 mb-3">

                                    <div class="col-6">
                                        <button class="btn btn-danger w-100" type="reset">Annuler</button>
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
<?php
include 'app/commun/footer_membre.php';

unset($_SESSION['save_errors'], $_SESSION['errors']);
?>