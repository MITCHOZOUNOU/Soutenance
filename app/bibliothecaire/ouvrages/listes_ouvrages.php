<?php

if (empty($_SESSION['utilisateur_connecter_bibliothecaire'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/connexion');
    exit;
}
$title = 'Liste de3s ouvrages';
include './app/commun/header1.php';

$page_ouvrages = 1;

if (isset($_SESSION["page_ouvrages"]) && !empty($_SESSION["page_ouvrages"])) {
    $page_ouvrages = $_SESSION["page_ouvrages"];
}

if (isset($_SESSION["titre"]) && !empty($_SESSION["titre"])) {
    $titre = $_SESSION["titre"];
}

$liste_ouvrages = liste_ouvrages($page_ouvrages);

if (!empty($titre)) {
    $liste_ouvrages = liste_ouvrages($page_ouvrages, $titre);
}

?>

<main class="container mt-3">

    <div class="row">
        <div class="col-md-6">
            <h1>Listes Ouvrages</h1>
        </div>

        <div class="col-md-6 text-end cefp-list-add-btn">
            <a href="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/ajouter_ouvrages" class="btn" style="background-color:black; color: white;">Ajouter Ouvrages</a>
        </div>

        <div class="row mt-3">
            <form action="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/traitement_listes_ouvrages" method="post">

                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" value="<?= !empty($titre) ? $titre : '' ?>" name="titre" placeholder="Rechercher par le titre de l'ouvrage">
                    </div>

                    <div class="text-center">
                        <button type="submit" value="s" name="search" class="btn btn-primary mt-3 mb-3 w-75">Rechercher</button>
                    </div>
                </div>

                <table class="table text-center table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">Nombre d'exemplaire</th>
                            <th scope="col">Nombre Emprunté</th>
                            <th scope="col">Nombre disponible</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (isset($liste_ouvrages) && !empty($liste_ouvrages)) {

                            foreach ($liste_ouvrages as $ouvrage) {

                                $auteur_principal = recup_auteur_par_num_aut($ouvrage["num_aut"]);

                                $cod_lang_ouvrage = recup_cod_langue_par_cod_ouv($ouvrage["cod_ouv"])['id_langue'];

                                $num_auteurs_secondaires = recup_num_auteurs_secondaires_par_cod_ouv($ouvrage["cod_ouv"]);

                                $num_domaines = recup_num_domaines_par_cod_ouv($ouvrage["cod_ouv"]);
                        ?>
                                <tr>
                                    <td scope="row"><?= $ouvrage['titre'] ?></td>
                                    <td><?= $ouvrage['nb_ex'] ?></td>
                                    <td>
                                        <?= is_null($ouvrage['nb_emprunter']) ? 0 : $ouvrage['nb_emprunter'] ?>
                                    </td>
                                    <td>
                                        <?= is_null($ouvrage['nb_emprunter']) ? $ouvrage['nb_ex'] : $ouvrage['nb_ex'] - $ouvrage['nb_emprunter'] ?>
                                    </td>
                                    <td>
                                        <a href="#" title="Détails" class="link-primary" data-bs-toggle="modal" data-bs-target="<?= '#ouvrage-detail' . $ouvrage['cod_ouv'] ?>"><i class="fas fa-eye"></i></a>

                                        <button type="submit" title="Modifier" name="edit" value="<?= $ouvrage['cod_ouv'] ?>" class="btn link-warning" style="background: none;"><i class="fas fa-edit"></i></button>

                                        <a href="#" class="link-danger" title="Supprimer" data-bs-toggle="modal" data-bs-target="<?= '#ouvrage-supprimer' . $ouvrage['cod_ouv'] ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal pour le boutton details-->
                                <div class="modal modal-blur fade" id="<?= 'ouvrage-detail' . $ouvrage['cod_ouv'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Détails sur l'ouvrage <?= $ouvrage['titre'] ?> </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p class="fw-bold">Langue : <?= recup_langue_par_cod_lang($cod_lang_ouvrage)['lib_lang'] ?></p>
                                                <p class="fw-bold">Année de publication : <?= $ouvrage["periodicite"] ?></p>
                                                <p class="fw-bold">AUTEUR PRINCIPAL : <?= $auteur_principal['nom_aut'] . ' ' . $auteur_principal['prenoms_aut'] ?></p>
                                                <?php
                                                if (!empty($num_auteurs_secondaires)) {
                                                ?>
                                                    <p class="fw-bold">Auteurs Secondaires :
                                                        <?php
                                                        foreach ($num_auteurs_secondaires as $num_auteur_secondaire) {
                                                        ?>
                                                            <?= ' | ' . recup_auteur_par_num_aut($num_auteur_secondaire['id_auteur_secondaire'])['nom_aut'] . ' ' . recup_auteur_par_num_aut($num_auteur_secondaire['id_auteur_secondaire'])['prenoms_aut'] ?>
                                                        <?php
                                                        }
                                                        ?>
                                                    </p>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if (!empty($num_domaines)) {
                                                ?>
                                                    <p class="fw-bold">Domaines :
                                                        <?php
                                                        foreach ($num_domaines as $num_domaine) {
                                                        ?>
                                                            <?= ' | ' . recup_domaine_par_cod_dom($num_domaine['id_domaine'])['lib_dom'] ?>
                                                        <?php
                                                        }
                                                        ?>
                                                    </p>
                                                <?php
                                                }
                                                ?>
                                                <img class="resizable-image" src="<?= $ouvrage['image'] ?>" alt="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal pour le bouton supprimer-->
                                <div class="modal fade" id="<?= 'ouvrage-supprimer' . $ouvrage['cod_ouv'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Supprimer l'ouvrage</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr(e) de vouloir supprimer l'ouvrage <?= $ouvrage['titre'] ?> ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                                <button type="submit" name="delete" value="<?= $ouvrage['cod_ouv'] ?>" class="btn btn-danger">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } elseif (empty($liste_ouvrages)) {
                            echo '<p class = "text-center"> Aucun résultat.</p>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="" style="display: flex; justify-content:end;">
                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous" id="example2_previous">

                                <button type="submit" name="precedent" value="<?= $page_ouvrages - 1 ?>" class="page-link text-dark">
                                    < </button>

                            </li>

                            <li class="paginate_button page-item active">

                                <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link bg-dark border-0">

                                    <?= $page_ouvrages; ?>

                                </a>

                            </li>

                            <li class="paginate_button page-item next" id="example2_next">

                                <button type="submit" name="suivant" value="<?= $page_ouvrages + 1 ?>" class="page-link text-dark">
                                    >
                                </button>

                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

    </div>
</main>

<?php
include './app/commun/footer1.php';

unset($_SESSION["titre"], $_SESSION['page_ouvrages']);

?>