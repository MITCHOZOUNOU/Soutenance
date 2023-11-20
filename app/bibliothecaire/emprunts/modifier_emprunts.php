<?php

if (empty($_SESSION['utilisateur_connecter_bibliothecaire'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
    exit;
}
$title = 'Modifier les emprunts';
include './app/commun/header1.php';

$emprunt = [];

if (!empty($_SESSION["num_emp"])) {

    $emprunt = recup_emprunt_par_num_emp($_SESSION["num_emp"]);

    //die(var_dump($emprunt));

    if (empty($emprunt)) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue bloque le processus';
        header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
        exit;
    }

    $cod_ouvrages = recup_cod_ouvs_par_num_emp($emprunt["num_emp"]);

    $cod_ouvs = [];

    foreach ($cod_ouvrages as $cod_ouv) {
        $cod_ouvs[] = $cod_ouv['cod_ouv'];
    }

} else {

    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue bloque le processus';
    header('location:' . PROJECT_ROM . 'bibliothecaire/emprunts/listes_emprunts');
    exit;
}

?>

<main class="mt-2">

    <?php

    if (!empty($_SESSION['modifier_emprunt_errors'])) {
        $erreurs = $_SESSION['modifier_emprunt_errors'];
    }

    if (!empty($_SESSION['data'])) {
        $data = $_SESSION['data'];
    }

    ?>

    <div class="row">

        <div class="col-md-6">
            <h2>Modifier Emprunts</h2>
        </div>

        <div class="col-md-6 text-end cefp-list-add-btn">
            <a href="<?= PROJECT_ROM ?>bibliothecaire/emprunts/listes_emprunts" class="btn" style="background-color:black; color: white;">Liste Emprunts</a>
        </div>

    </div>

    <div class="mt-3">

        <form action="<?= PROJECT_ROM ?>bibliothecaire/emprunts/traitement_modifier_emprunts" method="post">

            <div class="mb-3 col-md-12">
                <label for="numero-membre" class="form-label">Membre :</label>
                <span class="text-danger">*</span>
                <select class="form-select <?= isset($erreurs['num_mem']) ? 'is-invalid' : '' ?>" id="numero-membre" name="num_mem">
                    <option value="0">Sélectionner le membre auquel associé cet emprunt.</option>
                    <?php

                    $liste_membres = recup_membre();

                    foreach ($liste_membres as $membre) {
                    ?>

                        <option value="<?= $membre['id'] ?>" <?php if (!empty($data['num_mem']) && $data['num_mem'] == $membre['id']) {
                                                                    echo 'selected';
                                                                } elseif ($emprunt['num_mem'] == $membre['id']) {
                                                                    echo 'selected';
                                                                } ?>>
                            <?= $membre['nom'] . ' ' . $membre['prenom'] ?>
                        </option>

                    <?php
                    }
                    ?>
                </select>
                <?php if (isset($erreurs['num_mem'])) : ?>
                    <div class="invalid-feedback">
                        <?= $erreurs['num_mem'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3 col-md-12">
                <label for="code-ouvrage" class="form-label">Ouvrage(s) :</label>
                <span class="text-danger">*</span>
                <select class="form-select select2bs4 <?= isset($erreurs['cod_ouv']) ? 'is-invalid' : '' ?>" id="code-ouvrage" name="cod_ouv[]" multiple>
                    <option value="0">Sélectionner le(s) ouvrage(s) à emprunter</option>
                    <?php

                    $liste_ouvrages = liste_ouvrages();

                    foreach ($liste_ouvrages as $ouvrage) {
                    ?>
                        <option value="<?= $ouvrage['cod_ouv'] ?>" <?php echo (!empty($data['cod_ouv']) && in_array($ouvrage['cod_ouv'], $data['cod_ouv'])) || in_array($ouvrage['cod_ouv'], $cod_ouvs) ? 'selected' : '' ?>><?= $ouvrage['titre'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <?php if (isset($erreurs['cod_ouv'])) : ?>
                    <div class="invalid-feedback">
                        <?= $erreurs['cod_ouv'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-end">
                <button class="btn" type="submit" style="background-color:black; color: white;">Modifier</button>
            </div>

        </form>

    </div>

</main>

<?php
include './app/commun/footer1.php';
unset($_SESSION['modifier_emprunt_errors'], $_SESSION['data']);

?>