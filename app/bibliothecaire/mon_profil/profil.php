<?php
if (!empty($_SESSION['utilisateur_connecter_bibliothecaire"'])) {
	header('location:' . PROJECT_ROM . 'bibliothecaire/connexion');
}
$title = 'Profil';
include('./app/commun/header1.php');
if (!empty($_SESSION['utilisateur_connecter_bibliothecaire']['id'])) {
}
//die(var_dump(($_SESSION['utilisateur_connecter_bibliothecaire']['avatar'])));
//if (!empty($_SESSION['desactivation-errors']) && !empty($_SESSION['desactivation-errors'])) {
//	$errors = $_SESSION['desactivation-errors'];
//}
//
//if (!empty($_SESSION['passe']) && !empty($_SESSION['passe'])) {
//	$errors = $_SESSION['passe'];
//}
// die(var_dump($_SESSION['utilisateur_connecter_bibliothecaire']['avatar']));
?>

<main id="main">

	<div class="pagetitle">
		<h1>Profil</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="acceuil">Home</a></li>
				<li class="breadcrumb-item active">Profil</li>
			</ol>
		</nav>
	</div><!-- End Page Title -->

	<section class="section profile text-align:center" ;>
		<div class="row">
			<div class="col-xl-4">

				<div class="card">

					<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
						<a href="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] == 'no_image' ?  PROJECT_ROM . 'public/images/user.png' : $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] ?>">
							<img src="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] == 'no_image' ?  PROJECT_ROM . 'public/images/user.png' : $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] ?>" style="width: 160px;" alt="Profile" class="img-fluid" class="rounded-circle">

						</a>
						<h4><?= $_SESSION['utilisateur_connecter_bibliothecaire']['nom'] ?></h4>
						<h4><?= $_SESSION['utilisateur_connecter_bibliothecaire']['prenom'] ?></h4>
						<h5><?= $_SESSION['utilisateur_connecter_bibliothecaire']['profil'] ?></h5>
					</div>

					<div class="row" style="text-align: center; display:flex;">

					<form action="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/traitement_maj_photo" method="post" enctype="multipart/form-data">
						<div class="col-sm-10 offset-1 text-center text-secondary">
							<label class="form-label" for="customFile" style="color: gray;">Changer ma photo de profil</label>
							<input type="file" class="form-control " id="image" name="image" >
						</div>

						<div class="row">
							
							<div class="col-6 mt-2 offset-3 ">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal0" style="font-size: revert; padding: 5px;">Mettre à jour</button>
								<button type="button" class="btn btn-danger mt-1 text-white" data-bs-toggle="modal" data-bs-target="#modal5"><i class="fa fa-trash"></i> Supprimer</button>
							</div>


						</div>


						<!-- maj_photo Form -->
						<div class=" text-center col-sm-3" style="justify-content: center; margin-top: 31px;">

							<div class="col-md-8 col-lg-12">
								<div class="text-center" style="color: #070b3a;">
									<!-- Modal -->

									
										<div class="modal fade" id="modal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Mettre à jour la photo de profil</h5>
														<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<div class="row mb-3">
															<label for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour modifier la photo. </label>
															<br>
															<div class="col-md-8 col-lg-12">
																<input type="password" id="MP" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
														<button type="submit" name="change_photo" class="btn btn-primary">Valider</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>

							</div>

						</div>
					</div>

					<!-- suppression_photo Form -->
						<div class="row">
						<form action="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/traitement_supprimer_photo" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">

							<div class="col-md-8 col-lg-12">
								<div class="text-center" style="color: #070b3a;">
									<!-- Modal -->
									<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" name="supprimer_photo" id="exampleModalLabel" style="text-transform: uppercase;">Supprimer la photo de profil</h5>
													<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<div class="row mb-3">
														<label for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuiller entrer votre mot de passe pour supprimer la photo. </label>
														<br>
														<div class="col-md-8 col-lg-12">
															<input type="password" id="MP" name="mot_de_passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
													<button type="submit" name="supprimer_photo" class="btn btn-primary">Valider</button>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

					</form>
					<hr>
				</div>
				<div class="card">


					<div class="pt-2 d-flex flex-column align-items-center pb-4">
						<h3 class="card-title">Paramètres de compte</h3>
						<!----message de succès global à la connexion----->
						<?php
						if (!empty($_SESSION['desactivation-errors']) && !empty($_SESSION['desactivation-errors'])) {
						?>
							<div class="alert alert-danger" style="color: white; background-color:#dc3545; border-radius: 15px; text-align:center;">
								<?= $_SESSION['desactivation-errors'] ?>
							</div>
						<?php
						}
						?>
						<!-- Settings Form -->
						<div class="row mb-3" style="display: contents; text-align:center;">

							<div class="col-md-8 col-lg-9">
								<form action="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/desactivation" method="post">
									<div class="row mb-3">
										<div class="col-md-8 col-lg-12">
											<button type="button" name="desactiver-compte" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactiver"><i class="bi bi-x-octagon-fill"> Désactiver le compte</i></button>

											<div class="text-center" style="color: #070b3a;">
												<!-- Modal -->
												<div class="modal fade" id="desactiver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">
																	Mot de passe
																</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
																</button>
															</div>
															<div class="modal-body">
																<div class="row mb-3">
																	<label for="mot_de_passe" class="col-12 col-form-label" style="color: #070b3a;">
																		Veuiller entrer votre mot de passe pour
																		appliquer l'action.</label>
																	<br>
																	<div class="col-md-8 col-lg-12">
																		<input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler
																</button>
																<button type="submit" name="desactivation" class="btn btn-danger">Valider
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>


								<form action="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/supprimer" method="post">
									<div class="row mb-3">
										<div class="col-md-6 col-lg-12">
											<button type="button" name="supprimer-compte" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer"><i class="bi bi-trash-fill"> Supprimer le compte</i></button>

											<div class="text-center" style="color: #070b3a;">
												<!-- Modal -->
												<div class="modal fade" id="supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Mot de
																	passe</h5>
																<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
																</button>
															</div>
															<div class="modal-body">
																<div class="row mb-3">
																	<label for="mot_de_passe" class="col-12 col-form-label" style="color: #070b3a;">
																		Veuiller entrer votre mot de passe pour
																		appliquer l'action.</label>
																	<br>
																	<div class="col-md-8 col-lg-12">
																		<input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler
																</button>
																<button type="submit" name="supprimer" class="btn btn-danger">Valider
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div>
						</div>
						<!-- End settings Form -->

					</div>

				</div>
			</div>

			<div class="col-xl-8">
				<div class="card">
					<div class="card-body">
						<div class="tab-content">
							<div class="profile-edit pt-3">
								<h3 class="card-title">Modifications des informations personnelles :</h3>
								<!-- Message d'erreur global quand la modification a échoué -->
								<?php
								if (!empty($_SESSION['passe']) && !empty($_SESSION['passe'])) {
								?>
									<div class="alert alert-danger" style="color: white; background-color: #dc3545; border-radius: 15px; padding: 2%; text-align:center;">
										<?= $_SESSION['passe'] ?>
									</div>
								<?php
								}

								//die(var_dump($_SESSION));
								?>

								<!-- Message de succès global quand la modification a réussi -->
								<?php
								if (!empty($_SESSION['success']) && !empty($_SESSION['success'])) {
								?>
									<div class="alert alert-danger" style="color: white; background-color:#2bc717 ; border-radius: 15px; padding: 2%; text-align:center;">
										<?= $_SESSION['success'] ?>
									</div>
								<?php
								}
								?>

								<!-- Profile Edit Form -->


								<form action="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/modifier_profil" method="post">
									<div class="row mb-3">
										<label for="nom" class="col-md-4 col-lg-3 col-form-label">
											Nom
											<span class="text-danger"> (*)</span>
											:
										</label>
										<div class="col-md-8 col-lg-9">
											<input name="nom" type="text" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['nom']) ? 'is-invalid' : '' ?>" id="fullName" value="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['nom'] ?>">
											<?php if (!empty($_SESSION['modifier-profil-erreur']['nom'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['nom'] ?>
												</div>
											<?php } ?>
										</div>
									</div>

									<div class="row mb-3">
										<label for="prenom" class="col-md-4 col-lg-3 col-form-label">
											Prénoms
											<span class="text-danger"> (*)</span>
											:
										</label>
										<div class="col-md-8 col-lg-9">
											<input name="prenom" type="text" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['prenom']) ? 'is-invalid' : '' ?>" id="fullname" value="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['prenom'] ?>">
											<?php if (!empty($_SESSION['modifier-profil-erreur']['prenom'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['prenom'] ?>
												</div>
											<?php } ?>
										</div>
									</div>


									<div class="row mb-3">
										<label for="adresse" class="col-md-4 col-lg-3 col-form-label">Adresse : </label>
										<div class="col-md-8 col-lg-9">
											<input name="adresse" type="text" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['adresse']) ? 'is-invalid' : '' ?>" id="adresse" placeholder="Veuillez ajouter votre adresse" value="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['adresse'] ?>">
											<?php if (!empty($_SESSION['modifier-profil-erreur']['adresse'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['adresse'] ?>
												</div>
											<?php } ?>
										</div>
									</div>

									<div class="row mb-3">
										<label for="nom_utilisateur" class="col-md-4 col-lg-3 col-form-label">
											Nom d'utilisateur
											<span class="text-danger"> (*)</span>
											:
										</label>
										<div class="col-md-8 col-lg-9">
											<input name="nom_utilisateur" type="text" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['nom_utilisateur']) ? 'is-invalid' : '' ?>" id="nom_utilisateur" value="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['nom_utilisateur'] ?> ">
											<?php if (!empty($_SESSION['modifier-profil-erreur']['nom_utilisateur'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['nom_utilisateur'] ?>
												</div>
											<?php } ?>
										</div>
									</div>

									<div class="row mb-3">
										<label for="telephone" class="col-md-4 col-lg-3 col-form-label">Téléphone :</label>
										<div class="col-md-8 col-lg-9">
											<input name="telephone" type="text" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['telephone']) ? 'is-invalid' : '' ?>" id="telephone" placeholder="Veuillez renseigner votre numéro de téléphone" value="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['telephone'] ?>">
											<?php if (!empty($_SESSION['modifier-profil-erreur']['telephone'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['telephone'] ?>
												</div>
											<?php } ?>
										</div>
									</div>

									<div class="row mb-3">
										<label for="date_naissance" class="col-md-4 col-lg-3 col-form-label">
											Date de naissance :
										</label>
										<div class="col-md-8 col-lg-9">
											<input name="date_naissance" type="date" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['date_naissance']) ? 'is-invalid' : '' ?>" id="date_naissance" placeholder="Veuillez renseigner votre date de naissance" value="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['date_naissance'] ?>">
											<?php if (!empty($_SESSION['modifier-profil-erreur']['date_naissance'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['date_naissance'] ?>
												</div>
											<?php } ?>
										</div>
									</div>
								

									<div class="row mb-3">
										<label for="traitement_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Mot de passe
											<span class="text-danger"> (*)</span>
											:
										</label>
										<div class="col-md-8 col-lg-9">
											<input type="password" class="form-control <?= isset($_SESSION['modifier-profil-erreur']['mot_de_passe']) ? 'is-invalid' : '' ?>" name="mot_de_passe" value="<?php if (isset($data["mot_de_passe"]) && !empty($data["mot_de_passe"])) ?>" id="mot_de_passe" placeholder=" Veuillez entrer un mot de passe">
											<?php
											if (!empty($_SESSION['modifier-profil-erreur']['mot_de_passe'])) { ?>
												<div class="invalid-feedback">
													<?= $_SESSION['modifier-profil-erreur']['mot_de_passe'] ?>
												</div>
											<?php } ?>
										</div>
									</div>


									<div class="text-center">
										<button type="submit" name="sauvegarder" class="btn w-30" style="background-color:black; color: white;">
											Enregistrer
										</button>
									</div>
								</form>
								<!-- End Profile Edit Form -->

							</div>
						</div>
					</div>
				</div>


				<div class="card">
					<div class="card-body">
						<div class="tab-content">
							<div class="profile-change-password">
								<!-- Change Password Form -->
								<h3 class="card-title">Changer votre mot de passe :</h3>
								<form action="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/changer_mot_de_passe" method="post">

									<div class="row mb-3">
										<label for="changer_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Mot
											de passe actuel :</label>
										<div class="col-md-8 col-lg-9">
											<input name="mot_de_passe" type="password" class="form-control" placeholder="Entrer votre mot de passe actuel" id="mot_de_passe">
											<span class="text-danger">
												<?php
												if (isset($errors["mot_de_passe"]) && !empty($errors["mot_de_passe"])) {
													echo $errors["mot_de_passe"];
												}
												?>
											</span>
										</div>
									</div>

									<div class="row mb-3">
										<label for="changer_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Nouveau
											mot de passe :</label>
										<div class="col-md-8 col-lg-9">
											<input name="nouveau_mot_de_passe" type="password" class="form-control" placeholder="Entrer le nouveau mot de passe avec au moins 08 caractères" id="nouveau_mot_de_passe">
											<span class="text-danger">
												<?php
												if (isset($errors["nouveau_mot_de_passe"]) && !empty($errors["nouveau_mot_de_passe"])) {
													echo $errors["nouveau_mot_de_passe"];
												}
												?>
											</span>
										</div>
									</div>

									<div class="row mb-3">
										<label for="changer_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Confirmer
											mot de passe :</label>
										<div class="col-md-8 col-lg-9">
											<input name="confirmer_mot_de_passe" type="password" class="form-control" placeholder="Entrer à nouveau le nouveau mot de passe" id="confirmer_mot_de_passe">
											<span class="text-danger">
												<?php
												if (isset($errors["confirmer_mot_de_passe"]) && !empty($errors["confirmer_mot_de_passe"])) {
													echo $errors["confirmer_mot_de_passe"];
												}
												?>
											</span>
										</div>
									</div>

									<div class="text-center">
										<button type="submit" class="btn w-30" style="background-color:black; color: white;">Changement</button>
									</div>
								</form>
								<!-- End Change Password Form -->

							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</section>

</main>
<!-- End #main -->

<?php
unset($_SESSION['desactivation-errors'], $_SESSION['passe'], $_SESSION['success']);
include('./app/commun/footer1.php');
?>