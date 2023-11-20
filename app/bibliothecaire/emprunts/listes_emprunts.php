<?php

if (empty($_SESSION['utilisateur_connecter_bibliothecaire'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
    exit;
}
$title = 'Liste des emprunts';
include './app/commun/header1.php';

$page_emprunts = 1;

if (isset($_SESSION["page_emprunts"]) && !empty($_SESSION["page_emprunts"])) {
    $page_emprunts = $_SESSION["page_emprunts"];
}

if (isset($_SESSION["num_empt"]) && !empty($_SESSION["num_empt"])) {
    $num_emp = $_SESSION["num_empt"];
}

if (isset($_SESSION["num_mem"]) && !empty($_SESSION["num_mem"])) {
    $membre = $_SESSION["num_mem"];
}

$liste_emprunts = liste_emprunts($page_emprunts);

if (!empty($num_emp)) {
    $liste_emprunts = liste_emprunts($page_emprunts, $num_emp);
}

if (!empty($membre)) {
    $liste_emprunts = liste_emprunts($page_emprunts, null, $membre);
}

if (!empty($num_emp) && !empty($membre)) {
    $liste_emprunts = liste_emprunts($page_emprunts, $num_emp, $membre);
}

?>

<main class="container mt-3">

    <div class="row">

        <div class="col-md-6">
            <h1>Listes Emprunts</h1>
        </div>

        <div class="col-md-6 text-end cefp-list-add-btn">
            <a href="<?= PROJECT_ROM ?>bibliothecaire/emprunts/ajouter_emprunts" class="btn" style="background-color:black; color: white;">Ajouter un emprunts</a>
        </div>

        <div class="row mt-3">
            <form action="<?= PROJECT_ROM ?>bibliothecaire/emprunts/traitement_listes_emprunts" method="post">

                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" value="<?= !empty($num_emp) ? $num_emp : '' ?>" name="num_emp" placeholder="Rechercher par le numéro d'emprunt">
                    </div>

                    <div class="col-md-6">
                        <select class="form-select select2bs4" name="num_mem">
                            <option value="0">Rechercher par le membre emprêteur</option>
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

                <table class="table text-center table-hover">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Date requête</th>
                            <th scope="col">Date approbation</th>
                            <th scope="col">Date butoir retour</th>
                            <th scope="col">Emprêteur</th>
                            <th scope="col">Ouvrages</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (isset($liste_emprunts) && !empty($liste_emprunts)) {

                            foreach ($liste_emprunts as $emprunt) {

                                $membre = recup_membre($emprunt["num_mem"]);

                                $cod_ouvs = recup_cod_ouvs_par_num_emp($emprunt["num_emp"]);
                        ?>
                                <tr>
                                    <td>
                                        <?= $emprunt["num_emp"] ?>
                                    </td>
                                    
                                    <td>
                                        <?= date('d-m-Y H:i:s', strtotime($emprunt["creer_le"])) ?>
                                    </td>

                                    <td>
                                        <?= !empty($emprunt["date_approbation"]) ? date('d-m-Y H:i:s', strtotime($emprunt["date_approbation"])) : '-' ?>
                                    </td>

                                    <td>
                                        <?= !empty($emprunt["date_butoir_retour"]) ? date('d-m-Y H:i:s', strtotime($emprunt["date_butoir_retour"])) : '-' ?>
                                    </td>

                                    <td>
                                        <?= $membre[0]['nom'] . ' ' . $membre[0]['prenom'] ?>
                                    </td>

                                    <td>

                                        <?php
                                        if (!empty($cod_ouvs)) {
                                        ?>
                                            <?php
                                            foreach ($cod_ouvs as $cod_ouv) {
                                            ?>
                                                <?= recup_ouvrage($cod_ouv['cod_ouv'])['titre'] ?> <?= check_if_book_returned($emprunt["num_emp"], $cod_ouv['cod_ouv']) ? "&nbsp;<i class='fas fa-check text-success' title='Ouvrage retourné'>" . "</i>" . "<br>" : "&nbsp;<i class='fas fa-spinner fa-spin text-danger' title='Pas encore retourné'>" . "</i>" . '<br>' ?>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>

                                    </td>

                                    <td>
                                        <?php
                                        if ($emprunt['est_actif'] == 0) {
                                        ?>
                                        <button type="submit" title="Approuver" name="approve" value="<?= $emprunt['num_emp'] ?>" class="btn link-success" style="background: none;" ><i class="fas fa-check"></i></button>
                                        <?php
                                        }
                                        ?>
                                        <button type="submit" title="Modifier" name="edit" value="<?= $emprunt['num_emp'] ?>" class="btn link-warning" style="background: none;" ><i class="fas fa-edit"></i></button>
                                        &nbsp;
                                        <a href="#" title="Supprimer" class="link-danger" data-bs-toggle="modal" data-bs-target="<?= '#emprunt-supprimer' . $emprunt['id'] ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>

                                <!-- Modal pour le bouton supprimer-->
                                <div class="modal fade" id="<?= 'emprunt-supprimer' . $emprunt['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Supprimer l'emprunt</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr(e) de vouloir supprimer cet emprunt ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                                <button type="submit" name="delete" value="<?= $emprunt['num_emp'] ?>" class="btn btn-danger">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } elseif (empty($liste_emprunts)) {
                            echo '<p class = "text-center"> Aucun résultat.</p>';
                        }
                        ?>
                    </tbody>
                </table>

                <div class="" style="display: flex; justify-content:end;">
                    <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                        <ul class="pagination">
                            <li class="paginate_button page-item previous" id="example2_previous">

                                <button type="submit" name="precedent" value="<?= $page_emprunts - 1 ?>" class="page-link text-dark">
                                    < </button>

                            </li>

                            <li class="paginate_button page-item active">

                                <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link bg-dark border-0">

                                    <?= $page_emprunts; ?>

                                </a>

                            </li>

                            <li class="paginate_button page-item next" id="example2_next">

                                <button type="submit" name="suivant" value="<?= $page_emprunts + 1 ?>" class="page-link text-dark">
                                    >
                                </button>

                            </li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal pour le boutton details-->
        <div class="modal modal-blur fade" id="cefp-emprunt-modifier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Détails sur l'emprunt </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Contenu du détails sur l'auteur
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour le bouton supprimer-->
        <div class="modal fade" id="cefp-emprunt-supprimer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supprimer l'auteur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Etes vous sur de vouloir supprimer cet auteur ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                        <button type="button" class="btn btn-danger">Oui</button>
                    </div>
                </div>
            </div>
        </div>

</main>
<?php
include './app/commun/footer1.php';

unset($_SESSION["num_emp"], $_SESSION["num_empt"], $_SESSION["num_mem"], $_SESSION['page_emprunts']);

?>