<?php

if (empty($_SESSION['utilisateur_connecter_bibliothecaire'])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/dashboard/index');
    exit;
}
$title = 'Ajouter emprunts';
include './app/commun/header1.php';

//die(var_dump($liste_membres = recup_membre("indelicat ou pas")));

?>

<main class="mt-2">

    <?php

    if (!empty($_SESSION['ajout_emprunt_errors'])) {
        $erreurs = $_SESSION['ajout_emprunt_errors'];
    }

    if (!empty($_SESSION['data'])) {
        $data = $_SESSION['data'];
    }

    ?>

    <div class="row">

        <div class="col-md-6">
            <h2>Ajouter Emprunts</h2>
        </div>

        <div class="col-md-6 text-end cefp-list-add-btn">
            <a href="<?= PROJECT_ROM ?>bibliothecaire/emprunts/listes_emprunts" class="btn" style="background-color:black; color: white;">Liste Emprunts</a>
        </div>

    </div>

    <div class="mt-3">

        <form action="<?= PROJECT_ROM ?>bibliothecaire/emprunts/traitement_ajouter_emprunts" method="post">

            <div class="mb-3 col-md-12">
                <label for="numero-membre" class="form-label">Membre :</label>
                <span class="text-danger">*</span>
                <select class="form-select <?= isset($erreurs['num_mem']) ? 'is-invalid' : '' ?>" id="numero-membre" name="num_mem">
                    <option value="0">Sélectionner le membre auquel associé cet emprunt.</option>
                    <?php

                    $liste_membres = recup_membre();

                    foreach ($liste_membres as $membre) {
                        if (!check_if_exist('membre_indelicat', 'num_mem', $membre['id'])) {
                            $selected = $data['num_mem'] == $membre['id'] ? 'selected' : '';
                            echo '<option value="' . $membre['id'] . '" ' . $selected . '>' . $membre['nom'] . ' ' .  $membre['prenom'] . '</option>';
                        }
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
                        <option value="<?= $ouvrage['cod_ouv'] ?>" <?php echo !empty($data['cod_ouv']) && in_array($ouvrage['cod_ouv'], $data['cod_ouv']) ? 'selected' : '' ?>><?= $ouvrage['titre'] ?></option>
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

            <input type="checkbox" id="more" name="more" <?= !empty($data['more']) ? 'checked' : '' ?> value="plus">
            <label for="more">Autre emprunt à ajouter (Cochez cette case s'il y a un autre emprunt à ajouter)</label>

            <div class="text-end">
                <button class="btn" type="submit" style="background-color:black; color: white;">Ajouter</button>
            </div>

        </form>

    </div>

</main>

<?php
include './app/commun/footer1.php';
unset($_SESSION['ajout_emprunt_errors'], $_SESSION['data']);

?>