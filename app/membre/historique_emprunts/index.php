<?php

if (empty($_SESSION['utilisateur_connecter_membre'])) {
    header('location:' . PROJECT_ROM . 'membre/connexion');
    exit;
}

$title = "Historique d'emprunts";

include("app/commun/header_membre.php");

$page_emprunts = 1;

if (!empty($params[3])) {
    $page_emprunts = $params[3];
}

if (isset($_SESSION["num_empt"]) && !empty($_SESSION["num_empt"])) {
    $num_emp = $_SESSION["num_empt"];
}

$liste_emprunts = liste_emprunts($page_emprunts);

if (!empty($num_emp)) {
    $liste_emprunts = liste_emprunts($page_emprunts, $num_emp);
}

//die(var_dump($_SERVER));
//die(var_dump(check_if_book_returned('BPE/0003/23', 4)));
?>

<main class="container mt-5">

    <div class="section-title py-0" data-aos="fade-up">
        <h2>Historique</h2>
        <p>Emprunts</p>
    </div>

    <div class="row mt-3" data-aos="fade-left">
        <form action="<?= PROJECT_ROM ?>membre/historique_emprunts/traitement_historique_emprunts" method="post">
            <?php
            if (isset($liste_emprunts) && !empty($liste_emprunts)) {
            ?>
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mt-2">
                                <div class="row g-3">
                                    <div class="col-md">
                                        <input type="text" class="form-control" value="<?= !empty($num_emp) ? $num_emp : '' ?>" name="num_emp" placeholder="Rechercher par le N° d'emprunt" title="Rechercher par le N° d'emprunt">
                                    </div>
                                    <div class="col-md">
                                        <button type="submit" value="s" name="search" class="btn" style="background-color: #010483; color: white;">Rechercher</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-tools mt-2">
                                <ul class="pagination pagination-md float-right">
                                    <li class="page-item"><a class="page-link" href="<?= $page_emprunts - 1 <= 0 ? PROJECT_ROM . 'membre/historique_emprunts/index/1' : PROJECT_ROM . 'membre/historique_emprunts/index/' . $page_emprunts - 1 ?>">-</a></li>
                                    <li class="page-item active"><a class="page-link" href="#" style="background-color: #010483; border-color:#010483;"><?= $page_emprunts; ?></a></li>
                                    <li class="page-item"><a class="page-link" href="<?= PROJECT_ROM . 'membre/historique_emprunts/index/' . $page_emprunts + 1 ?>">+</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0 table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" style="color: #010483;">N° Emprunts</th>
                                        <th scope="col" style="color: #010483;">Date requête</th>
                                        <th scope="col" style="color: #010483;">Date approbation</th>
                                        <th scope="col" style="color: #010483;">Date butoir retour</th>
                                        <th scope="col" style="color: #010483;">Ouvrages</th>
                                        <th scope="col" style="color: #010483;">Statuts</th>

                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $is_books_returned = [];

                                    foreach ($liste_emprunts as $emprunt) {

                                        $membre = recup_membre($emprunt["num_mem"]);

                                        $cod_ouvs = recup_cod_ouvs_par_num_emp($emprunt["num_emp"]);

                                        //die(var_dump($cod_ouvs));

                                        foreach ($cod_ouvs as $cod_ouv) {
                                            $is_books_returned[$emprunt["num_emp"]][] = check_if_book_returned($emprunt["num_emp"], $cod_ouv['cod_ouv']);
                                        }

                                        if (!empty($is_books_returned[$emprunt["num_emp"]])) {
                                            $is_books_returned[$emprunt["num_emp"]] = array_unique($is_books_returned[$emprunt["num_emp"]]);
                                        }

                                        //die(var_dump($is_books_returned));

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
                                                <?php
                                                if (!empty($cod_ouvs)) {
                                                ?>
                                                    <?php
                                                    foreach ($cod_ouvs as $cod_ouv) {
                                                    ?>
                                                        <?= recup_ouvrage($cod_ouv['cod_ouv'])['titre'] ?> <?= check_if_book_returned($emprunt["num_emp"], $cod_ouv['cod_ouv']) ? "&nbsp;<i class='bx bx-checkbox-checked text-success' title='Ouvrage retourné'>" . "</i>" . "<br>" : "&nbsp;<i class='bx bx-checkbox-minus text-danger' title='Pas encore retourné'>" . "</i>" . '<br>' ?>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($emprunt['est_actif'] == 1) {
                                                ?>
                                                    <span class="badge bg-success">Approuvé</span>
                                                <?php
                                                } else {
                                                ?>
                                                    <span class="badge bg-warning">En cours d'examen...</span>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <?php
                                            if ($emprunt["est_actif"] == 0) {
                                            ?>
                                                <td>
                                                    <a href="<?= PROJECT_ROM . 'membre/modifier_emprunt/index/' . $emprunt['num_emp'] ?>" title="Modifier" class="link-warning"><i class="bx bxs-edit"></i></a>&nbsp;&nbsp;
                                                    <a href="#" title="Supprimer" class="link-danger" data-bs-toggle="modal" data-bs-target="<?= '#emprunt-supprimer' . $emprunt['id'] ?>"><i class="bi bi-trash"></i></a>
                                                </td>
                                            <?php
                                            } elseif (!empty($is_books_returned[$emprunt["num_emp"]]) && sizeof($is_books_returned[$emprunt["num_emp"]]) == 1 && $is_books_returned[$emprunt["num_emp"]][0] == true) {
                                            ?>
                                                <td>
                                                    <a href="#" title="Supprimer" class="link-danger" data-bs-toggle="modal" data-bs-target="<?= '#emprunt-supprimer' . $emprunt['id'] ?>"><i class="bi bi-trash"></i></a>
                                                </td>
                                            <?php
                                            } else {
                                            ?>
                                                <td></td>
                                            <?php
                                            }
                                            ?>
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
                                    } //die(var_dump($is_books_returned));
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            <?php
            } elseif (empty($liste_emprunts)) {
                echo '<p class = "text-center"> Aucun emprunt disponible à cette page.</p>';
            }
            ?>
        </form>
    </div>

</main>

<?php
include("app/commun/footer_membre.php");

unset($_SESSION["num_empt"]);

?>