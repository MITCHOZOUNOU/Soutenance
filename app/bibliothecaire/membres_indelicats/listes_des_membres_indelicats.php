<?php

if (empty($_SESSION['utilisateur_connecter_bibliothecaire'])) {
  header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
  exit;
}
$title = 'Listes membres indelicats';
include './app/commun/header1.php';

$page_membre_indelicat = 1;

if (isset($_SESSION["page_membre_indelicat"]) && !empty($_SESSION["page_membre_indelicat"])) {
  $page_membre_indelicat = $_SESSION["page_membre_indelicat"];
}

if (isset($_SESSION["num_mem"]) && !empty($_SESSION["num_mem"])) {
  $membre = $_SESSION["num_mem"];
}

$liste_membres_indelicats = recup_membres_indelicats($page_membre_indelicat);

if (!empty($membre)) {
  $liste_membres_indelicats = recup_membres_indelicats($page_membre_indelicat, $membre);
}

//die(var_dump($liste_membres_indelicats));

?>

<main class="container mt-3">

  <div class="row">

    <div class="col-md-6">
      <h1>Listes Membres Indelicats</h1>
    </div>

    <div class="col-md-6 text-end cefp-list-add-btn">
      <a href="<?= PROJECT_ROM ?>bibliothecaire/membres/listes_des_membres" class="btn" style="background-color:black; color: white;">Membres</a>
    </div>

    <div class="row mt-3">
      <form action="<?= PROJECT_ROM ?>bibliothecaire/membres_indelicats/traitement_listes_des_membres_indelicats" method="post">

        <div class="row">

          <div class="col-md-12">
            <select class="form-select select2bs4" name="num_mem">
              <option value="0">Rechercher un membre</option>
              <?php

              $liste_membres = recup_membre();

              foreach ($liste_membres as $_membre) {
              ?>
                <option value="<?= $_membre['id'] ?>" <?php echo (!empty($membre) && $_membre['id'] == $membre) ? 'selected' : '' ?>><?= $_membre['nom'] . ' ' . $_membre['prenom'] ?></option>
              <?php
              }
              ?>
            </select>
          </div>

          <div class="text-center">
            <button type="submit" value="s" name="search" class="btn btn-primary mt-3 mb-3 w-75">Rechercher</button>
          </div>
        </div>

        <?php
        if (!empty($liste_membres_indelicats)) {
        ?>
          <table class="table text-center table-hover">
            <thead>
              <tr>
                <th scope="col">Membres Indelicats</th>
                <th scope="col">Motifs</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($liste_membres_indelicats as $key => $membre_indelicat) {

                $ouvrage = recup_ouvrage($membre_indelicat['cod_ouv']);

              ?>
                <tr>
                  <td>
                    <?= recup_membre($membre_indelicat['num_mem'])[0]["nom"] . ' ' . recup_membre($membre_indelicat['num_mem'])[0]["prenom"] ?>
                  </td>

                  <td>
                    <?php
                    if (!is_null($membre_indelicat['date_effective_retour']) && (new DateTime($membre_indelicat['date_butoir_retour']) < new DateTime($membre_indelicat['date_effective_retour']))) {
                      echo '- L\'ouvrage <strong>' . $ouvrage['titre'] . '</strong> emprunté le <strong>' . date('Y-m-d H:i:s', strtotime($membre_indelicat['date_butoir_retour'] . " -1 week")) . '</strong> <br>a été ramené le <strong>' . $membre_indelicat['date_effective_retour'] . '</strong> au lieu du <strong>' . $membre_indelicat['date_butoir_retour'] . '</strong>.<br>';
                    }
                    if ($membre_indelicat['etat_ouvrage'] == 'mauvais') {
                      echo '- L\'ouvrage <strong>' . $ouvrage['titre'] . '</strong> a été ramené en mauvais état.';
                    }
                    if (is_null($membre_indelicat['date_effective_retour']) && is_null($membre_indelicat['etat_ouvrage'])) {
                      echo '- L\'ouvrage <strong>' . $ouvrage['titre'] . '</strong> emprunté le <strong>' . date('Y-m-d H:i:s', strtotime($membre_indelicat['date_butoir_retour'] . " -1 week")) . '</strong> <br>n\'a été ramené. Date normale de retour : <strong>' . $membre_indelicat['date_butoir_retour'] . '</strong>.<br>';
                    }
                    ?>
                  </td>

                  <td>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?= $membre_indelicat['id'] ?>">Réglémenter</a>
                  </td>

                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        <?php
        } elseif (empty($liste_membres_indelicats)) {
          echo '<p class = "text-center"> Aucun résultat.</p>';
        }
        ?>

        <div class="" style="display: flex; justify-content:end;">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            <ul class="pagination">
              <li class="paginate_button page-item previous" id="example2_previous">

                <button type="submit" name="precedent" value="<?= $page_membre_indelicat - 1 ?>" class="page-link text-dark">
                  < </button>

              </li>

              <li class="paginate_button page-item active">

                <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link bg-dark border-0">

                  <?= $page_membre_indelicat; ?>

                </a>

              </li>

              <li class="paginate_button page-item next" id="example2_next">

                <button type="submit" name="suivant" value="<?= $page_membre_indelicat + 1 ?>" class="page-link text-dark">
                  >
                </button>

              </li>
            </ul>
          </div>
        </div>
      </form>
    </div>
    </table>

    <?php
    if (!empty($liste_membres_indelicats)) {
      foreach ($liste_membres_indelicats as $key => $membre_indelicat) {

    ?>
        <form action="<?= PROJECT_ROM ?>bibliothecaire/membres_indelicats/traitement_listes_des_membres_indelicats" method="post">
          <div class="modal fade" id="modal<?= $membre_indelicat['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel" style="text-transform: uppercase;">Mettre ce membre en règle</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <input type="text" name="bank" value="" class="form-control mb-3" placeholder="Veuillez entrer le nom de votre banque">

                  <input type="text" name="account_number" class="form-control" placeholder="Veuillez entrer votre numéro de compte">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  <button type="submit" name="reglementer" value="<?= $membre_indelicat['num_emp'] . ',' . $membre_indelicat['cod_ouv'] ?>" class="btn btn-primary">Soumettre</button>
                </div>
              </div>
            </div>
          </div>
        </form>
    <?php
      }
    }
    ?>

</main>
<?php
include './app/commun/footer1.php';

unset($_SESSION['page_membre_indelicat'])

?>