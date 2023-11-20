<?php
if (empty($_SESSION["utilisateur_connecter_bibliothecaire"])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/connexion');
    exit;
}
$title = 'Ouvrages retourner';
include './app/commun/header1.php';

?>

<section class="section dashboard">
    <main id="main" class="main">
        <div class="row">

            <?php

            if (!empty($_SESSION['ouvrage_retourner_errors'])) {
                $erreurs = $_SESSION['ouvrage_retourner_errors'];
            }

            if (!empty($_SESSION['data'])) {
                $data = $_SESSION['data'];
            }

            ?>

            <div class="col-md-6">
                <h1>Retourner des ouvrages</h1>
            </div>

            <div class="col-md-6 text-end bibliotheque-list-add-btn">
                <a href="listes_ouvrages" class="btn btn-primary">Liste des ouvrages</a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 bd-example">
                <form action="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/traitement_ouvrages_retourner" method="post">

                    <div id="container" class="container">

                        <div class="row input-block">

                            <div class="col-md-3">
                                <label for="emprunt" class="form-label">N° Emprunt</label>
                                <span class="text-danger">*</span>
                                <select class="form-select <?= isset($erreurs['emprunt']) ? 'is-invalid' : '' ?>" id="emprunt" name="emprunt[]">
                                    <option value="0">Sélectionner le numéro d'emprunt</option>
                                    <?php

                                    $liste_emprunts = liste_emprunts();

                                    foreach ($liste_emprunts as $emprunt) {
                                        $selected = $data['emprunt'] == $emprunt['num_emp'] ? 'selected' : '';
                                        echo '<option value="' . $emprunt['num_emp'] . '" ' . $selected . '>' . $emprunt['num_emp'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <?php if (isset($erreurs['emprunt'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $erreurs['emprunt'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-3">
                                <label for="membre" class="form-label">Membre</label>
                                <span class="text-danger">*</span>
                                <select class="form-select <?= isset($erreurs['membre']) ? 'is-invalid' : '' ?>" id="membre" name="membre[]">
                                    <option value="0">Sélectionner le membre</option>
                                    <?php

                                    $liste_membres = recup_membre();

                                    foreach ($liste_membres as $membre) {
                                        $selected = $data['membre'] == $membre['id'] ? 'selected' : '';
                                        echo '<option value="' . $membre['id'] . '" ' . $selected . '>' . $membre['nom'] . ' ' . $membre['prenom'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <?php if (isset($erreurs['membre'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $erreurs['membre'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-3">
                                <label for="ouvrage" class="form-label">Ouvrage</label>
                                <span class="text-danger">*</span>
                                <select class="form-select <?= isset($erreurs['ouvrage']) ? 'is-invalid' : '' ?>" id="ouvrage" name="ouvrage[]">
                                    <option value="0">Sélectionner l'ouvrage</option>
                                    <?php

                                    $liste_ouvrages = liste_ouvrages();

                                    foreach ($liste_ouvrages as $ouvrage) {
                                        $selected = $data['ouvrage'] == $ouvrage['cod_ouv'] ? 'selected' : '';
                                        echo '<option value="' . $ouvrage['cod_ouv'] . '" ' . $selected . '>' . $ouvrage['titre'] . '</option>';
                                    }
                                    ?>
                                </select>
                                <?php if (isset($erreurs['ouvrage'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $erreurs['ouvrage'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-3">
                                <label for="etat" class="form-label">Etat</label>
                                <span class="text-danger">*</span>
                                <select class="form-select <?= isset($erreurs['etat']) ? 'is-invalid' : '' ?>" id="etat" name="etat[]">
                                    <option value="0">Sélectionner l'état de l'ouvrage</option>
                                    <option value="mauvais">Mauvais</option>
                                    <option value="bon">Bon</option>
                                </select>
                                <?php if (isset($erreurs['etat'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= $erreurs['etat'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="btn w-30 mt-2 link-primary add-btn" style="background: none;">Autre ouvrage ? Cliquez ici</button>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center mt-3">
                            <button type="submit" class="btn btn-success w-30">
                                Valider
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
</section>

<script>
    // Fonction pour ajouter un bloc de champs input
    function addInputBlock() {
        const container = document.getElementById('container');
        const inputBlock = document.querySelector('.input-block').cloneNode(true);

        // Modifier le bouton pour permettre la suppression
        const addButton = inputBlock.querySelector('.add-btn');
        addButton.textContent = 'Retirer cette ligne';
        addButton.removeEventListener('click', addInputBlock);
        addButton.addEventListener('click', removeInputBlock);

        container.appendChild(inputBlock);
    }

    // Fonction pour supprimer un bloc de champs input
    function removeInputBlock(event) {
        const container = document.getElementById('container');
        const inputBlock = event.target.parentNode;

        container.removeChild(inputBlock);
    }

    // Écouteur pour le bouton + initial
    const initialAddButton = document.querySelector('.add-btn');
    initialAddButton.addEventListener('click', addInputBlock);
</script>


<?php
include './app/commun/footer1.php';
unset($_SESSION['ouvrage_retourner_errors'], $_SESSION['data']);
?>