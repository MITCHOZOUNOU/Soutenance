<?php

if (empty($_SESSION['utilisateur_connecter_membre'])) {
    header('location:' . PROJECT_ROM . 'membre/connexion');
    exit;
}
$title = "Modifier emprunts";

include './app/commun/header_membre.php';

$emprunt = [];

if (!empty($params[3])) {

    $cod_ouvrages = recup_cod_ouvs_par_num_emp($params[3]);

    $cod_ouvs = [];

    foreach ($cod_ouvrages as $cod_ouv) {
        $cod_ouvs[] = $cod_ouv['cod_ouv'];
    }

} else {
    $_SESSION['global_membre_error'] = 'Une action inattendue bloque le processus';
    header('location:' . PROJECT_ROM . 'membre/historique_emprunts');
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
            <h2 class="mt-5">Modifier Emprunt</h2>
        </div>

        <div class="col-md-6 text-end cefp-list-add-btn mt-3">
            <a href="<?= PROJECT_ROM ?>membre/historique_emprunts" class="btn" style="background-color:#010483; color: white;">Historique des emprunts</a>
        </div>

    </div>

    <div class="py-5">

        <form action="<?= PROJECT_ROM."membre/modifier_emprunt/traitement_modifier_emprunt/".$params[3]?>" method="post">

            <div class="mb-3 col-md-12">
                <label for="code-ouvrage" class="form-label">Ouvrage(s) :</label>
                <span class="text-danger">*</span>
                <select class="form-select select2bs4 <?= isset($erreurs['cod_ouv']) ? 'is-invalid' : '' ?>" id="code-ouvrage" name="cod_ouv[]" multiple>
                    <option value="0">Sélectionner d'autres ouvrages à emprunter</option>
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

            <div class="text-center">
                <button class="btn" type="submit" style="background-color:#010483; color: white;">Modifier</button>
            </div>

        </form>

    </div>

</main>

<?php
include './app/commun/footer_membre.php';
unset($_SESSION['modifier_emprunt_errors'], $_SESSION['data']);
?>