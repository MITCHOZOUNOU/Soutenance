<?php

if (empty($_SESSION['utilisateur_connecter_membre'])) {
    header('location:' . PROJECT_ROM . 'membre/connexion');
    exit;
}

$title = "Emprunt";
include 'app/commun/header_membre.php';

if (!empty($params[3])) {
    $cod_ouv = $params[3];
}

?>

<main class="mt-4">

    <?php

    if (!empty($_SESSION['ajouter_emprunt_errors'])) {
        $erreurs = $_SESSION['ajouter_emprunt_errors'];
    }

    if (!empty($_SESSION['data'])) {
        $data = $_SESSION['data'];
    }

    ?>

    <div class="row">

        <div class="col-md-6">
            <h2>Emprunts</h2>
        </div>

        <div class="col-md-6 text-end cefp-list-add-btn">
            <a href=" <?= PROJECT_ROM ?>membre/catalogue/index" class="btn" style="background-color: #010483; color: white;">Catalogue</a>
        </div>

    </div>

    <div class="mt-3">

        <form action="<?= !empty($cod_ouv) ?  PROJECT_ROM . 'membre/emprunter/traitement_emprunter/' . $cod_ouv : PROJECT_ROM . 'membre/emprunter/traitement_emprunter' ?>" method="post">

            <div class="mb-3 col-md-12">
                <label for="code-ouvrage" class="form-label">Sélectionner Ouvrage(s) :</label>
                <span class="text-danger">*</span>
                <select class="form-select select2bs4 <?= isset($erreurs['cod_ouv']) ? 'is-invalid' : '' ?>" id="code-ouvrage" name="cod_ouv[]" multiple>
                    <option value="0">Sélectionner d'autres ouvrages à emprunter</option>
                    <?php

                    $liste_ouvrages = liste_ouvrages();

                    foreach ($liste_ouvrages as $ouvrage) {
                    ?>
                        <option value="<?= $ouvrage['cod_ouv'] ?>" <?php echo (!empty($data['cod_ouv']) && in_array($ouvrage['cod_ouv'], $data['cod_ouv'])) || (!empty($cod_ouv) && $ouvrage['cod_ouv'] == $cod_ouv) ? 'selected' : '' ?>><?= $ouvrage['titre'] ?></option>
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

            <div class="text-center mb-3">
                <button type="submit" class="btn" style="background-color: #010483; color: white;">Soumettre</button>
            </div>

            <div class="container card">
                <button type="button" class="btn btn-danger mb-4">A LIRE (IMPORTANT)</button>
                <p class="text-danger fw-bold">Règles d'emprunts</p>
                    <p>
                        A compter du jour d'approbation de votre requête d'emprunt :
                    </p>
                    <ol>
                    <li>Vous êtes tenu(e) de rapporter les ouvrages empruntés dans un délai d'une semaine (07 jours).</li>
                    <li>Tout ouvrage emprunté doit être rapporter dans son état originel au moment de l'emprunt.</li>
                </ol>
                <p class="text-danger fw-bold">Risque(s) encouru(s) en cas de violation des précédentes règles</p>
                <ul class="mb-0">
                    <li>Vous serez marqué comme membre indélicat et suspendu(e)s de nouveaux emprunts sans réparation préalable des éventuels dommages causés.</li>
                </ul>
            </div>

        </form>

    </div>

</main>

<?php
include 'app/commun/footer_membre.php';
unset($_SESSION['ajouter_emprunt_errors'], $_SESSION['data']);
?>