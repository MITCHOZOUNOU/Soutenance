<?php
$title = 'Catalogue';

include("app/commun/header_membre.php");

$page_ouvrages = 1;

if (!empty($params[3])) {
    $page_ouvrages = $params[3];
}

if (isset($_SESSION["titre"]) && !empty($_SESSION["titre"])) {
    $titre = $_SESSION["titre"];
}

if (isset($_SESSION["domaine"]) && !empty($_SESSION["domaine"])) {
    $domaine = $_SESSION["domaine"];
}

$liste_ouvrages = liste_ouvrages($page_ouvrages);

if (!empty($titre)) {
    $liste_ouvrages = liste_ouvrages($page_ouvrages, $titre);
}

if (!empty($domaine)) {
    $liste_ouvrages = liste_ouvrages($page_ouvrages, null, $domaine);
}

if (!empty($titre) && !empty($domaine)) {
    $liste_ouvrages = liste_ouvrages($page_ouvrages, $titre, $domaine);
}

if (!empty($_SESSION['utilisateur_connecter_membre'])) {
    $membre_indelicat = recup_membres_indelicats(null, $_SESSION['utilisateur_connecter_membre']['id']);

    !empty($membre_indelicat) ? $membre_indelicat_ouvrage = recup_ouvrage($membre_indelicat[0]['cod_ouv']) : '';
}


?>

<main class="container">

    <?php
    if (!empty($_SESSION['utilisateur_connecter_membre']) && check_if_exist('membre_indelicat', 'num_mem', $_SESSION['utilisateur_connecter_membre']['id'])) {
    ?>
        <section class="d-lg-none p-3"></section>
        <div class="alert alert-danger bg-danger alert-dismissible fade show" style="color: white; border-radius: 15px;" role="alert">
            <strong><i class="fas fa-exclamation-triangle text-light"></i> &nbsp;&nbsp;&nbsp;Membre indélicat.</strong>
            <ul class="mb-1 mt-2">
                <li>
                    <?php
                    if (!is_null($membre_indelicat[0]['date_effective_retour']) && (new DateTime($membre_indelicat[0]['date_butoir_retour']) < new DateTime($membre_indelicat[0]['date_effective_retour']))) {
                        echo 'L\'ouvrage <strong>' . $membre_indelicat_ouvrage['titre'] . '</strong> emprunté le <strong>' . date('d-m-Y H:i:s', strtotime($membre_indelicat[0]['date_butoir_retour'] . " -1 week")) . '</strong> a été ramené le <strong>' . date('d-m-Y H:i:s', strtotime($membre_indelicat[0]['date_effective_retour'])) . '</strong> bien après la date limite de retour <strong>' . date('d-m-Y H:i:s', strtotime($membre_indelicat[0]['date_butoir_retour'])) . '</strong>.<br>';
                    }
                    if ($membre_indelicat[0]['etat_ouvrage'] == 'mauvais') {
                        echo 'L\'ouvrage <strong>' . $membre_indelicat_ouvrage['titre'] . '</strong> a été ramené en mauvais état.<br>';
                    }
                    if (is_null($membre_indelicat[0]['date_effective_retour']) && is_null($membre_indelicat[0]['etat_ouvrage'])) {
                        echo 'L\'ouvrage <strong>' . $membre_indelicat_ouvrage['titre'] . '</strong> emprunté le <strong>' . date('d-m-Y H:i:s', strtotime($membre_indelicat[0]['date_butoir_retour'] . " -1 week")) . '</strong> n\'a été ramené jusqu\'à ce jour. Date limite de retour : <strong>' . date('d-m-Y H:i:s', strtotime($membre_indelicat[0]['date_butoir_retour'])) . '</strong>.<br>';
                    }
                    ?>
                </li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
    ?>

    <form action="<?= PROJECT_ROM ?>membre/catalogue/traitement_catalogue" method="post">

        <div class="content">
            <!-- ======= Book Section ======= -->
            <section class="team">
                <div class="container">

                    <div class="section-title py-0" data-aos="fade-up">
                        <h2>Catalogue</h2>
                        <p>Nos Ouvrages</p>
                    </div>

                    <div class="row" data-aos="fade-left">
                        <div class="row mb-3 justify-content-end g-3">

                            <div class="col-md">
                                <input type="text" class="form-control <?= !empty($erreurs['titre_ouvrage']) ? 'is-invalid' : '' ?>" id="titre-ouvrage" value="<?= !empty($titre) ? $titre : '' ?>" name="titre_ouvrage" placeholder="Rechercher un ouvrage par son titre">
                            </div>

                            <div class="col-md d-none d-lg-block">
                                <select class="form-select select2bs4 <?= isset($erreurs['cod_dom']) ? 'is-invalid' : '' ?>" name="cod_dom">
                                    <option value="0">Trier par domaine</option>
                                    <?php

                                    $liste_domaines = get_liste_domaine();

                                    foreach ($liste_domaines as $_domaine) {
                                    ?>
                                        <option value="<?= $_domaine['cod_dom'] ?>" <?php echo (!empty($domaine) && $_domaine['cod_dom'] == $domaine) ? 'selected' : '' ?>><?= $_domaine['lib_dom'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md d-block d-lg-none">
                                <div class="d-inline-block">
                                    <select class="form-select select2bs4 <?= isset($erreurs['cod_dom']) ? 'is-invalid' : '' ?>" name="cod_dom">
                                        <option value="0">Trier par domaine</option>
                                        <?php

                                        $liste_domaines = get_liste_domaine();

                                        foreach ($liste_domaines as $_domaine) {
                                        ?>
                                            <option value="<?= $_domaine['cod_dom'] ?>" <?php echo (!empty($domaine) && $_domaine['cod_dom'] == $domaine) ? 'selected' : '' ?>><?= $_domaine['lib_dom'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md">
                                <button type="submit" value="s" name="search" class="btn w-100" style="background-color: #010483; color: white;">Rechercher</button>
                            </div>
                        </div>
                        <?php

                        if (isset($liste_ouvrages) && !empty($liste_ouvrages)) {
                        ?>

                            <?php

                            foreach ($liste_ouvrages as $ouvrage) {
                            ?>

                                <div class="col-lg-3 col-md-6 p-lg-5">
                                    <div class="member" data-aos="zoom-in" data-aos-delay="100">
                                        <div class="pic"><img src="<?= $ouvrage["image"] ?>" class="img-fluid" style="width: 346px; height: 346px;" alt=""></div>
                                        <div class="member-info mb-2">
                                            <h4><?= strtoupper($ouvrage["titre"]) ?></h4><a href="#" title="Voir détails" data-bs-toggle="modal" data-bs-target="#ouv-detail<?= $ouvrage["cod_ouv"] ?>" class="stretched-link"></a>
                                            <?php
                                            if (!empty($_SESSION['utilisateur_connecter_membre']) && !check_if_exist('membre_indelicat', 'num_mem', $_SESSION['utilisateur_connecter_membre']['id'])) {
                                            ?>
                                                <a href="<?= PROJECT_ROM . "membre/emprunter/index/" . $ouvrage["cod_ouv"] ?>" class="member-info d-none d-lg-block">Emprunter <i class="fas fa-hand-holding"></i></a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <a href="#" title="Voir détails" data-bs-toggle="modal" data-bs-target="#ouv-detail<?= $ouvrage["cod_ouv"] ?>" class="stretched-link"></a>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>
                    </div>

                </div>
            </section>
            <!-- End Stats Section -->

            <div class="" style="display: flex; justify-content:center;">
                <div class="row justify-content-center dataTables_paginate paging_simple_numbers" id="example2_paginate">

                    <ul class="pagination">
                        <li class="paginate_button page-item previous" id="example2_previous">
                            <a href="<?= $page_ouvrages - 1 <= 0 ? PROJECT_ROM . 'membre/catalogue/index/1' : PROJECT_ROM . 'membre/catalogue/index/' . $page_ouvrages - 1 ?>" class="page-link text-dark">précédent</a>
                        </li>

                        <li class="paginate_button page-item active">

                            <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link" style="background-color: #010483; border-color:#010483;">
                                <?= $page_ouvrages; ?>
                            </a>

                        </li>

                        <li class="paginate_button page-item next" id="example2_next">
                            <a href="<?= PROJECT_ROM . 'membre/catalogue/index/' . $page_ouvrages + 1 ?>" class="page-link text-dark">suivant</a>
                        </li>
                    </ul>

                </div>
            </div>
        <?php
                        } elseif (empty($liste_ouvrages)) {
                            echo '<h4 class = "text-center"> Aucun résultat sur cette page.</h4>';
                        }
        ?>

        </div>
    </form>

</main>

<!--Detail Modal-->

<?php
if (isset($liste_ouvrages) && !empty($liste_ouvrages)) {
?>
    <?php
    foreach ($liste_ouvrages as $ouvrage) {
        $auteur_principal = recup_auteur_par_num_aut($ouvrage["num_aut"]);

        $cod_lang_ouvrage = recup_cod_langue_par_cod_ouv($ouvrage["cod_ouv"])['id_langue'];

        $num_auteurs_secondaires = recup_num_auteurs_secondaires_par_cod_ouv($ouvrage["cod_ouv"]);

        $num_domaines = recup_num_domaines_par_cod_ouv($ouvrage["cod_ouv"]);
    ?>
        <div class="modal modal-blur fade" id="ouv-detail<?= $ouvrage["cod_ouv"] ?>" tabindex="-1" data-bs-backdrop='static' role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="color: #010483;">Détails <?= $ouvrage["titre"] ?></h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center">Nombre d'exemplaire</span>
                                                <span class="info-box-number text-center mb-0" style="color: #010483;"><?= $ouvrage["nb_ex"] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center">Langue</span>
                                                <span class="info-box-number text-center mb-0" style="color: #010483;"><?= recup_langue_par_cod_lang($cod_lang_ouvrage)['lib_lang'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center">Année de publication</span>
                                                <span class="info-box-number text-center mb-0" style="color: #010483;"><?= $ouvrage["periodicite"] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= $ouvrage["image"]; ?>" class="product-image" width="500" height="500" alt="Product Image">
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                                <h3 class="" style="line-height: 40px;"> <?= $ouvrage["titre"] ?></h3>
                                <hr>
                                <div class="">
                                    <div class="text-md">
                                        <h5 class="fw-bold">AUTEUR PRINCIPAL</h5>
                                        <p class="d-block"><?= $auteur_principal['prenoms_aut'] . ' ' . $auteur_principal['nom_aut'] ?></p>
                                    </div>

                                    <div class="text-md">
                                        <?php
                                        if (!empty($num_auteurs_secondaires)) {
                                        ?>
                                            <h5 class="fw-bold">AUTEURS SECONDAIRES</h5>
                                            <?php
                                            foreach ($num_auteurs_secondaires as $num_auteur_secondaire) {
                                            ?>
                                                <?= recup_auteur_par_num_aut($num_auteur_secondaire['id_auteur_secondaire'])['prenoms_aut'] . ' ' . recup_auteur_par_num_aut($num_auteur_secondaire['id_auteur_secondaire'])['nom_aut'] . '<br>' ?>
                                            <?php
                                            }
                                            ?>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <div class="text-md">
                                        <h5 class="fw-bold">DOMAINES</h5>
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
                                <hr>
                                <div class="text-center mt-5 mb-3">
                                    <?php
                                    if (!empty($_SESSION['utilisateur_connecter_membre']) && !check_if_exist('membre_indelicat', 'num_mem', $_SESSION['utilisateur_connecter_membre']['id'])) {
                                    ?>
                                        <a href="<?= PROJECT_ROM . "membre/emprunter/index/" . $ouvrage["cod_ouv"] ?>" class="btn" style="background-color: #010483; color:white;">Emprunter cet ouvrage</a>
                                    <?php
                                    } elseif (!empty($_SESSION['utilisateur_connecter_membre']) && check_if_exist('membre_indelicat', 'num_mem', $_SESSION['utilisateur_connecter_membre']['id'])) {

                                    ?>
                                        <div>
                                            <i class="fas fa-exclamation-triangle text-warning"></i>
                                            Vous avez été marqué en tant que membre indélicat. Rapprochez-vous de l'administration pour résoudre ce problème.
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
<?php
    }
}
?>

<?php
include("app/commun/footer_membre.php");

unset($_SESSION["titre"], $_SESSION["domaine"], $_SESSION['page_ouvrages']);

?>