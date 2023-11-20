<?php

if (!empty($_SESSION['utilisateur_connecter_membre'])) {
  header('location:' . PROJECT_ROM . 'membre/accueil');
  exit;
}

if (isset($_SESSION['data']) && !empty($_SESSION['data'])) {
  $data = $_SESSION['data'];
}

if (isset($_COOKIE['data_users']) and !empty($_COOKIE['data_users'])) {
  $users_mail = json_decode($_COOKIE['data_users']);
}

$title = 'Connexion';

include 'app/commun/header_membre.php';

?>

<div class="mt-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="d-block d-md-flex row">
        <div class="card">
          <div class="card-body">
            <?php
            if (isset($_SESSION['alerte']) && !empty($_SESSION['alerte'])) {
            ?>
              <div class="alert alert-danger bg-danger text-center" style="color: white;">
                <?= $_SESSION['alerte'] ?>
              </div>
            <?php
            }
            ?>

            <h3>Se connecter</h3>
            <p class="text-medium-emphasis">Entrer votre nom d'utilisateur et votre mot de passe pour vous connecter</p>
            <form action="<?= PROJECT_ROM ?>membre/connexion/traitement" method="post" novalidate class="row g-3 needs-validation" novalidate>
              <div class="col-12 mt-3">
                <label for="nom_utilisateur" class="form-label">Nom d'utilisateur
                  <span class="text-danger">(*)</span>
                </label>
                <div class="input-group has-validation">
                  <input type="text" class="form-control <?= isset($_SESSION['erreurs']['nom_utilisateur']) ? 'is-invalid' : '' ?>" name="nom_utilisateur" id="nom_utilisateur" value="<?php if (isset($data['nom_utilisateur']) && !empty($data['nom_utilisateur'])) {
                                                                                                                                                                                          echo $data['nom_utilisateur'];
                                                                                                                                                                                        } elseif (isset($users_mail)) {
                                                                                                                                                                                          echo $users_mail;
                                                                                                                                                                                          unset($_SESSION['data']);
                                                                                                                                                                                        } else {
                                                                                                                                                                                          echo '';
                                                                                                                                                                                        } ?>" placeholder="Veuillez entrer un nom d'utilisateur">
                  <?php
                  if (isset($_SESSION['erreurs']['nom_utilisateur'])) {
                  ?>
                    <div class="invalid-feedback">
                      <?= $_SESSION['erreurs']['nom_utilisateur'] ?>
                    </div>
                  <?php
                  }
                  ?>
                  <!---<div class="invalid-feedback">Choisir un nom d'utilisateur.</div>---->
                </div>
              </div>
              <div class="col-12 mt-3">
                <label for="mot_de_passe" class="form-label">Mot de passe
                  <span class="text-danger"> (*)</span>
                </label>
                <input type="password" class="form-control <?= isset($_SESSION['erreurs']['mot_de_passe']) ? 'is-invalid' : '' ?>" name="mot_de_passe" value="<?php if (isset($data["mot_de_passe"]) && !empty($data["mot_de_passe"])) {
                                                                                                                                                                echo $data["mot_de_passe"];
                                                                                                                                                              } else {
                                                                                                                                                                echo '';
                                                                                                                                                              } ?>" id="mot_de_passe" placeholder=" Veuillez entrer un mot de passe">
                <?php
                if (isset($_SESSION['erreurs']['mot_de_passe'])) {
                ?>
                  <div class="invalid-feedback">
                    <?= $_SESSION['erreurs']['mot_de_passe'] ?>
                  </div>
              </div>
            <?php
                }
            ?>
            <!---<div class="invalid-feedback">Entrer un mot de passe s'il vous plaît!</div>---->

            <div class="col-12 mt-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="se_rappeler" value="true" id="Se souvenir de moi">
                <label class="form-check-label" for="sesouvenirdemoi">Se souvenir de moi</label>
              </div>
            </div>
            <div class="col-12 mt-3">
              <div class="text-center">
                <button type="submit" class="btn" style="background-color: #010483; color: white;">Connexion</button>
              </div>
            </div>
            <div class=" col-12 mt-2">
              <div class="text-center">
                <a href="<?= PROJECT_ROM ?>membre/mot_de_passe_oublie">Mot de passe Oublié?</a>
                <div class="">
                  <a href="<?= PROJECT_ROM ?>membre/inscription">Inscrivez vous maintenant</a>
                </div>
              </div>
            </div>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php
unset($_SESSION['erreurs']);
unset($_SESSION['alerte']);
unset($_SESSION['validation-compte-message-success']);

include 'app/commun/footer_membre.php'

?>