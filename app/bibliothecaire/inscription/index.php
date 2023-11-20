<?php
if (!empty($_SESSION ['utilisateur_connecter_bibliothecaire"'])){
  header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
  exit;
}

if (isset($_SESSION['inscription-erreurs']) && !empty($_SESSION['inscription-erreurs'])) {
  $errors = $_SESSION['inscription-erreurs'];
}

if (isset($_SESSION['donnees-utilisateur']) && !empty($_SESSION['donnees-utilisateur'])) {
  $data = $_SESSION['donnees-utilisateur'];
}

$title = 'Inscription';

include 'app/commun/header.php';
?>

<div class="container">
        <div class="row justify-content-center" style="margin-top: 50px;">
          <div class="col-md-5">
          <a class="navbar-brand" href="#">
                    <img src="<?= PROJECT_ROM ?>public/images/logo.png" style="width: 500px;" class="img-fluid" alt="Logo">
                </a>
            <div class="card mb-4 mx-4">
              <div class="card-body p-4">
                <h3>S'inscrire (Bibliothecaire)</h3>
                <?php
                if (isset($_SESSION['inscription-message-success-global']) && !empty($_SESSION['inscription-message-success-global'])) {
                ?>
                  <div class="alert alert-primary" style="color: white; background-color: #31f40a; text-align:center; border-color: snow;">
                    <?= $_SESSION['inscription-message-success-global'] ?>
                  </div>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['inscription-message-erreur-global']) && !empty($_SESSION['inscription-message-erreur-global'])) {
                ?>
                  <div class="alert alert-primary" style="color: white; background-color: #9f0808; text-align:center; border-color: snow;">
                    <?= $_SESSION['inscription-message-erreur-global'] ?>
                  </div>
                <?php
                }
                ?>

              <p class="text-medium-emphasis">Entrer vos informations personnelles pour créer un compte </p>
              <form action="<?= PROJECT_ROM ?>bibliothecaire/inscription/traitement" method="post" class="row g-3 needs-validation">
              <div class="col-12 mb-3">
                      <label for="nom" class="form-label">Nom
                        <span class="text-danger"> (*)</span>
                      </label>
                      <input type="text"  class="form-control <?= isset($errors['nom']) ? 'is-invalid' : ''?>" name="nom" id="nom"   value="<?php if (isset($data["nom"]) && !empty($data["nom"])) {echo $data["nom"]; }else{ echo '';}?>"
                                    placeholder="Veuillez entrer votre nom">
                                    <?php
                                    if(isset($errors['nom'])){ 
                                    ?>
                                    <div class="invalid-feedback">
                                        <?=$errors['nom']?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                    </div>
               
                

                    <div class="col-12 mt-3">
                      <label for="prenom" class="form-label">Prénoms
                        <span class="text-danger"> (*)</span>
                      </label>
                      <input type="text"  class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : ''?>" name="prenom" id="prenom" value="<?php if (isset($data["prenom"]) && !empty($data["prenom"])) {echo $data["prenom"]; }else{ echo '';}?>" 
                                    placeholder="Veuillez entrer vos prénoms">
                                    <?php
                                    if(isset($errors['prenom'])){ 
                                    ?>
                                    <div class="invalid-feedback">
                                        <?=$errors['prenom']?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                      <!------<div class="invalid-feedback">Entrer vos prénoms s'il vous plaît!</div>---->
                    </div>
                    
                    <div class="col-12 mt-3">
                        <label for="nom_utilisateur" class="form-label">Nom d'utilisateur
                          <span class="text-danger">(*)</span>
                        </label>
                        <div class="input-group has-validation">
                         
                          <input type="text"  class="form-control <?= isset($errors['nom_utilisateur']) ? 'is-invalid' : ''?>" name="nom_utilisateur" id="nom_utilisateur" value="<?php if (isset($data["nom_utilisateur"]) && !empty($data["nom_utilisateur"])) {echo $data["nom_utilisateur"]; }else{ echo '';}?>"
                                      placeholder="Veuillez entrer un nom d'utilisateur">
                                      <?php
                                      if(isset($errors['nom_utilisateur'])){ 
                                      ?>
                                      <div class="invalid-feedback">
                                          <?=$errors['nom_utilisateur']?>
                                      </div>
                                      <?php
                                      }
                                      ?>
                          <!---<div class="invalid-feedback">Choisir un nom d'utilisateur.</div>---->
                        </div>

                    <div class="col-12 mt-3">
                      <label for="email" class="form-label"> Email
                        <span class="text-danger"> (*)</span>
                      </label>
                      <input type="email"  class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''?>" name="email" value="<?php if (isset($data["email"]) && !empty($data["email"])) {echo $data["email"]; }else{ echo '';}?>"
                                    id="email" placeholder="Veuillez entrer votre adresse email">
                                    <?php
                                    if(isset($errors['email'])){ 
                                    ?>
                                    <div class="invalid-feedback">
                                        <?=$errors['email']?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                      <!---<div class="invalid-feedback">Enter une adresse e-mail valide s'il vous plaît!</div>---->
                      </div>

                      <div class="col-12 mt-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe
                          <span class="text-danger"> (*)</span>
                        </label>
                        <input type="password"  class="form-control <?= isset($errors['mot_de_passe']) ? 'is-invalid' : ''?>" name="mot_de_passe" value="<?php if (isset($data["mot_de_passe"]) && !empty($data["mot_de_passe"])) {echo $data["mot_de_passe"]; }else{ echo '';}?>"
                                      id="mot_de_passe" placeholder=" Veuillez entrer un mot de passe">
                                      <?php
                                      if(isset($errors['mot_de_passe'])){ 
                                      ?>
                                      <div class="invalid-feedback">
                                          <?=$errors['mot_de_passe']?>
                                      </div>
                                      <?php
                                      }
                                      ?>
                        <!---<div class="invalid-feedback">Entrer un mot de passe s'il vous plaît!</div>---->
                      
                      </div>

                      <div class="col-12 mt-3">
                        <label for="repeter_le_mot_de_passe" class="form-label">Confirmer mot de passe
                          <span class="text-danger"> (*)</span>
                        </label>
                        <input type="password" class="form-control <?= isset($errors['repeter_le_mot_de_passe']) ? 'is-invalid' : ''?>" name="repeter_le_mot_de_passe" value="<?php if (isset($data["confirmer_mot_de_passe"]) && !empty($data["repeter_le_mot_de_passe"])) {echo $data["repeter_le_mot_de_passe"]; }else{ echo '';}?>"
                                      id="repeter_le_mot_de_passe" placeholder="Veuillez repeter le mot de passe">
                                      <?php
                                      if(isset($errors['repeter_le_mot_de_passe'])){ 
                                      ?>
                                      <div class="invalid-feedback">
                                          <?=$errors['repeter_le_mot_de_passe']?>
                                      </div>
                                      <?php
                                      }
                                      ?>
                        <!---<div class="invalid-feedback">Entrer un mot de passe s'il vous plaît!</div>---->
                        
                      </div>
                      

                      <div class="col-12 mt-3">
                        <button class="btn btn-primary w-100" type="submit" 
                       >Créer un compte</button>
                      </div>
                      <div class="col-12 mt-3">
                        <p class="small mb-0">Vous aviez déjà un compte? <a href="<?= PROJECT_ROM ?>bibliothecaire/connexion">Se Connecter</a></p>
                      </div>
          </form> 
          </div>
        </div>
  </div>
      <?php
      unset($_SESSION['inscription-message-success-global']);
      unset($_SESSION['errors']);
include 'app/commun/footer.php';

?>