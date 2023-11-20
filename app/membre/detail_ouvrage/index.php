<?php
$title = "Detail ouvrage";
include("app/commun/header_membre.php");

$ouvrage = [];

if (!empty($params[3])) {
    $ouvrage = recup_ouvrage_par_cod_ouv($params[3]);
}

if (empty($ouvrage)) {
    header('location:' . PROJECT_ROM . 'membre/catalogue');
    exit;
}

$auteur_principal = recup_auteur_par_num_aut($ouvrage["num_aut"]);

$cod_lang_ouvrage = recup_cod_langue_par_cod_ouv($ouvrage["cod_ouv"])['id_langue'];

$num_auteurs_secondaires = recup_num_auteurs_secondaires_par_cod_ouv($ouvrage["cod_ouv"]);

$num_domaines = recup_num_domaines_par_cod_ouv($ouvrage["cod_ouv"]);


?>

<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Détail de l'ouvrage</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Nombre d'exemplaire</span>
                                    <span class="info-box-number text-center text-muted mb-0"><?= $ouvrage["nb_ex"] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Langue</span>
                                    <span class="info-box-number text-center text-muted mb-0"><?= recup_langue_par_cod_lang($cod_lang_ouvrage)['lib_lang'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Année de publication</span>
                                    <span class="info-box-number text-center text-muted mb-0"><?= $ouvrage["periodicite"] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="<?= $ouvrage["image"]; ?>" class="product-image" alt="Product Image">
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h3 class="text-primary" style="line-height: 40px;"><i class="fas fa-book"></i> <?= $ouvrage["titre"] ?></h3>

                    <div class="">
                        <div class="text-md">
                            <h5 class="fw-bold">AUTEUR PRINCIPAL</h5>
                            <p class="d-block fw-bold"><?= $auteur_principal['nom_aut'] . ' ' . $auteur_principal['prenoms_aut'] ?></p>
                        </div>

                        <div class="text-md text-muted fw-bold">
                            <?php
                            if (!empty($num_auteurs_secondaires)) {
                            ?>
                                <h5>Auteurs Secondaires</h5>
                                <?php
                                foreach ($num_auteurs_secondaires as $num_auteur_secondaire) {
                                ?>
                                    <?= recup_auteur_par_num_aut($num_auteur_secondaire['id_auteur_secondaire'])['nom_aut'] . ' ' . recup_auteur_par_num_aut($num_auteur_secondaire['id_auteur_secondaire'])['prenoms_aut'] . '<br>' ?>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>
                        </div>
                        <hr>
                        <div class="text-md text-muted fw-bold">
                            <h5>DOMAINES</h5>
                            <?php
                            if (!empty($num_domaines)) {
                            ?>
                                <?php
                                foreach ($num_domaines as $num_domaine) {
                                ?>
                                    <?= recup_domaine_par_cod_dom($num_domaine['id_domaine'])['lib_dom'] . '<br>' ?>
                                <?php
                                }
                                ?>

                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="text-center mt-5 mb-3">
                        <?php
                        if (!empty($_SESSION['utilisateur_connecter_membre']) && !check_if_exist('membre_indelicat', 'num_mem', $_SESSION['utilisateur_connecter_membre']['id'])) {
                        ?>
                            <a href="<?= PROJECT_ROM . 'membre/emprunter/index/' . $ouvrage["cod_ouv"] ?>" class="btn btn-primary link-light">EMPRUNTER</a>
                        <?php
                        } elseif (!empty($_SESSION['utilisateur_connecter_membre']) && check_if_exist('membre_indelicat', 'num_mem', $_SESSION['utilisateur_connecter_membre']['id'])) {

                        ?>
                            <span><i class="fas fa-exclamation-triangle text-warning"></i> Vous avez été marqué en tant que membre indélicat. Veuillez vous rapprocher de l'administration de la bibliothèque pour résoudre ce problème.</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>

<?php
include("app/commun/footer_membre.php")

?>