<?php
if (!empty($_SESSION['utilisateur_connecter_membre"'])) {
	header('location:' . PROJECT_ROM . 'membre/connexion');
}
$title = "Profil";
include('./app/commun/header_membre.php');


if (!empty($_SESSION['errors']) && !empty($_SESSION['errors'])) {
	$errors = $_SESSION['errors'];
}

if (!empty($_SESSION['data']) && !empty($_SESSION['data'])) {
	$data = $_SESSION['data'];
}
?>

<main id="main" class="mt-5">

<div class="container" data-aos="fade-up">

	<div class="row">
		<div class="col-xl-4">

			<div class="card">
				<div class="card-header">
					<h1 class="">Profil</h1>
				</div>

				<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
					<a href="<?= $_SESSION['utilisateur_connecter_membre']['avatar'] == 'Non defini' ?  PROJECT_ROM . 'public/images/user.png' : $_SESSION['utilisateur_connecter_membre']['avatar'] ?>">
						<img src="<?= $_SESSION['utilisateur_connecter_membre']['avatar'] == 'Non defini' ?  PROJECT_ROM . 'public/images/user.png' : $_SESSION['utilisateur_connecter_membre']['avatar'] ?>" style="width: 150px;" alt="Profile" class="img-fluid rounded-circle">
					</a>
					<h5><?= $_SESSION['utilisateur_connecter_membre']['nom'] . ' ' . $_SESSION['utilisateur_connecter_membre']['prenom'] ?></h5>
					<h6 class="text-bold"><?= $_SESSION['utilisateur_connecter_membre']['profil'] ?></h6>
				</div>

				<div class="row" style="text-align: center; display:flex;">

					<form action="<?= PROJECT_ROM ?>membre/profil/traitement_maj_photo" method="post" enctype="multipart/form-data">
						<div class="col-sm-12 text-center text-secondary">
							<label class="form-label" for="customFile" style="color: gray;">Changer ma photo de profil</label>
							<input type="file" class="form-control" id="customFile" name="image" />
						</div>

						<div class="row">
							<div class="col-md mt-2 mb-4 g-3">
								<button type="button" class="btn" style="background-color: #010483; color: white;" data-bs-toggle="modal" data-bs-target="#modal0">Mettre à jour</button>
								<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal5"><i class="fa fa-trash"></i> Supprimer</button>
							</div>
						</div>

						<!-- maj_photo Form -->
						<div class=" text-center col-sm-3" style="justify-content: center;">

							<div class="col-md-8 col-lg-12">
								<div class="" style="color: #070b3a;">
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
														<p for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuillez entrer votre mot de passe pour modifier la photo. </p>
														<div class="col-md-8 col-lg-12">
															<input type="password" name="password" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
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
		<form action="<?= PROJECT_ROM ?>membre/profil/traitement_supprimer_photo" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">
			<div class="col-md-8 col-lg-12">
				<div style="color: #070b3a;">
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
										<p for="MP" class="col-12 col-form-label" style="color: #070b3a;">Veuillez entrer votre mot de passe pour supprimer la photo. </p>
										
										<div class="col-md-8 col-lg-12">
											<input type="password" name="mot_de_passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
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
		</form>
	</div>

	</div>

	<div class="card">
		<div class="pt-2 d-flex flex-column align-items-center pb-4">
			<h3 class="mb-3">Paramètres de compte</h3>
			<!-- Settings Form -->
			<div class="row mb-3" style="display: contents; text-align:center;">

				<div class="col-md-8 col-lg-9">
					<form action="<?= PROJECT_ROM ?>membre/profil/desactivation" method="post">
						<div class="row mb-3">
							<div class="col-md-8 col-lg-12">
								<button type="button" name="desactiver-compte" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactiver">Désactiver le compte</button>

								<div style="color: #070b3a;">
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
														<p class="col-12 col-form-label" style="color: #070b3a;">
															Veuillez entrer votre mot de passe pour appliquer l'action.
														</p>
														<div class="col-md-8 col-lg-12">
															<input type="password" name="mot_de_passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
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

					<form action="<?= PROJECT_ROM ?>membre/profil/supprimer" method="post">
						<div class="row mb-3">
							<div class="col-md-6 col-lg-12">
								<button type="button" name="supprimer-compte" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer">Supprimer le compte</button>

								<div style="color: #070b3a;">
									<!-- Modal -->
									<div class="modal fade" id="supprimer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Mot de passe</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
													</button>
												</div>
												<div class="modal-body">
													<div class="row mb-3">
														<p class="col-12 col-form-label" style="color: #070b3a;">
															Veuillez entrer votre mot de passe pour appliquer l'action.
														</p>
														<br>
														<div class="col-md-8 col-lg-12">
															<input type="password" name="mot_de_passe" class="form-control" placeholder="Veuillez entrer votre mot de passe" value="">
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
			<div class="card-header">
				<h3 class="mb-4">Modifications des informations personnelles</h3>
			</div>
			<div class="card-body">
				<div class="tab-content">
					<div class="profile-edit pt-3">

						<!-- Profile Edit Form -->

						<form action="<?= PROJECT_ROM ?>membre/profil/modifier_profil" method="post">
							<div class="row mb-3">
								<label for="nom" class="col-md-4 col-lg-3 col-form-label">
									Nom
									<span class="text-danger"> (*)</span>
									:
								</label>
								<div class="col-md-8 col-lg-9">
									<input name="nom" type="text" class="form-control <?= isset($_SESSION['errors']['nom']) ? 'is-invalid' : '' ?>" id="fullName" value="<?= !empty($data['nom']) ? $data['nom'] : $_SESSION['utilisateur_connecter_membre']['nom'] ?>">
									<?php if (!empty($_SESSION['errors']['nom'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['nom'] ?>
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
									<input name="prenom" type="text" class="form-control <?= isset($_SESSION['errors']['prenom']) ? 'is-invalid' : '' ?>" id="fullname" value="<?= !empty($data['prenom']) ? $data['prenom'] : $_SESSION['utilisateur_connecter_membre']['prenom'] ?>">
									<?php if (!empty($_SESSION['errors']['prenom'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['prenom'] ?>
										</div>
									<?php } ?>
								</div>
							</div>

							<div class="row mb-3">
								<label for="adresse" class="col-md-4 col-lg-3 col-form-label">Adresse : </label>
								<div class="col-md-8 col-lg-9">
									<input name="adresse" type="text" class="form-control <?= isset($_SESSION['errors']['adresse']) ? 'is-invalid' : '' ?>" id="adresse" placeholder="Veuillez ajouter votre adresse" value="<?= !empty($data['adresse']) ? $data['adresse'] : $_SESSION['utilisateur_connecter_membre']['adresse'] ?>">
									<?php if (!empty($_SESSION['errors']['adresse'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['adresse'] ?>
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
									<input name="nom_utilisateur" type="text" class="form-control <?= isset($_SESSION['errors']['nom_utilisateur']) ? 'is-invalid' : '' ?>" id="nom_utilisateur" value="<?= !empty($data['nom_utilisateur']) ? $data['nom_utilisateur'] : $_SESSION['utilisateur_connecter_membre']['nom_utilisateur'] ?> ">
									<?php if (!empty($_SESSION['errors']['nom_utilisateur'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['nom_utilisateur'] ?>
										</div>
									<?php } ?>
								</div>
							</div>

							<div class="row mb-3">
								<label for="telephone" class="col-md-4 col-lg-3 col-form-label">Téléphone :</label>
								<div class="col-md-8 col-lg-9">
									<input name="telephone" type="text" class="form-control <?= isset($_SESSION['errors']['telephone']) ? 'is-invalid' : '' ?>" id="telephone" placeholder="Veuillez renseigner votre numéro de téléphone" value="<?= !empty($data['telephone']) ? $data['telephone'] : $_SESSION['utilisateur_connecter_membre']['telephone'] ?>">
									<?php if (!empty($_SESSION['errors']['telephone'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['telephone'] ?>
										</div>
									<?php } ?>
								</div>
							</div>

							<div class="row mb-3">
								<label for="date_naissance" class="col-md-4 col-lg-3 col-form-label">
									Date de naissance :
								</label>
								<div class="col-md-8 col-lg-9">
									<input name="date_naissance" type="date" class="form-control <?= isset($_SESSION['errors']['date_naissance']) ? 'is-invalid' : '' ?>" id="date_naissance" placeholder="Veuillez renseigner votre date de naissance" value="<?= !empty($data['date_naissance']) ? $data['date_naissance'] : $_SESSION['utilisateur_connecter_membre']['date_naissance'] ?>">
									<?php if (!empty($_SESSION['errors']['date_naissance'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['date_naissance'] ?>
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
									<input type="password" class="form-control <?= isset($_SESSION['errors']['mot_de_passe']) ? 'is-invalid' : '' ?>" name="mot_de_passe" value="<?= !empty($data['mot_de_passe']) ? $data['mot_de_passe'] : '' ?>" id="mot_de_passe" placeholder=" Veuillez entrer votre mot de passe">
									<?php
									if (!empty($_SESSION['errors']['mot_de_passe'])) { ?>
										<div class="invalid-feedback">
											<?= $_SESSION['errors']['mot_de_passe'] ?>
										</div>
									<?php } ?>
								</div>
							</div>

							<div class="text-center">
								<button type="submit" name="sauvegarder" class="btn w-30" style="background-color: #010483; color: white;">
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
						<h3 class="mb-4">Changer votre mot de passe</h3>
						<form action="<?= PROJECT_ROM ?>membre/profil/changer_mot_de_passe" method="post">

							<div class="row mb-3">
								<label for="changer_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Mot de passe actuel</label>
								<div class="col-md-8 col-lg-9">
									<input name="mot_passe" type="password" class="form-control <?= isset($_SESSION['errors']['mot_passe']) ? 'is-invalid' : '' ?>" placeholder="Entrer votre mot de passe actuel" id="mot_de_passe" value="<?= !empty($data['mot_de_passe']) ? $data['mot_de_passe'] : '' ?>">
									<span class="text-danger">
										<?php
										if (isset($errors["mot_passe"]) && !empty($errors["mot_passe"])) {
											echo $errors["mot_passe"];
										}
										?>
									</span>
								</div>
							</div>

							<div class="row mb-3">
								<label for="changer_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
								<div class="col-md-8 col-lg-9">
									<input name="nouveau_mot_de_passe" type="password" class="form-control <?= isset($_SESSION['errors']['nouveau_mot_de_passe']) ? 'is-invalid' : '' ?>" placeholder="Entrer le nouveau mot de passe avec au moins 08 caractères" id="nouveau_mot_de_passe" value="<?= !empty($data['nouveau_mot_de_passe']) ? $data['nouveau_mot_de_passe'] : '' ?>">
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
								<label for="changer_mot_de_passe" class="col-md-4 col-lg-3 col-form-label">Confirmer mot de passe</label>
								<div class="col-md-8 col-lg-9">
									<input name="confirmer_mot_de_passe" type="password" class="form-control <?= isset($_SESSION['errors']['confirmer_mot_de_passe']) ? 'is-invalid' : '' ?>" placeholder="Entrer à nouveau le nouveau mot de passe" id="confirmer_mot_de_passe" value="<?= !empty($data['confirmer_mot_de_passe']) ? $data['confirmer_mot_de_passe'] : '' ?>">
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
								<button type="submit" class="btn w-30" style="background-color: #010483; color: white;">Changement</button>
							</div>
						</form>
						<!-- End Change Password Form -->

					</div>
				</div>
			</div>
		</div>


	</div>

	</div>
	</div>
</main>
<!-- End #main -->

<?php
unset($_SESSION['errors'], $_SESSION['data']);
include('./app/commun/footer_membre.php');
?>