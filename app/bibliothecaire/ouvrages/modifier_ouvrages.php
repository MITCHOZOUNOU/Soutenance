<?php
if (empty($_SESSION["utilisateur_connecter_bibliothecaire"])) {
    header('location:' . PROJECT_ROM . 'bibliothecaire/connexion');
    exit;
}
$title = 'Modifier des ouvrages';
include './app/commun/header1.php';

$ouvrage = [];

if (!empty($_SESSION["cod_ouv"])) {

    $ouvrage = recup_ouvrage_par_cod_ouv($_SESSION["cod_ouv"]);

    if (empty($ouvrage)) {
        $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue bloque le processus';
        header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/listes_ouvrages');
        exit;
    }

    $auteur_principal = recup_auteur_par_num_aut($ouvrage["num_aut"]);

    $cod_lang_ouvrage = recup_cod_langue_par_cod_ouv($ouvrage["cod_ouv"])['id_langue'];

    $num_auteurs_secondaires = recup_num_auteurs_secondaires_par_cod_ouv($ouvrage["cod_ouv"]);

    $num_domaines = recup_num_domaines_par_cod_ouv($ouvrage["cod_ouv"]);

    //die(var_dump($ouvrage["num_aut"]));

    $num_aut_secondaires = [];

    foreach ($num_auteurs_secondaires as $num_aut_sec) {
        $num_aut_secondaires[] = $num_aut_sec['id_auteur_secondaire'];
    }

    $num_doms = [];

    foreach ($num_domaines as $num_domaine) {
        $num_doms[] = $num_domaine['id_domaine'];
    }

    $_SESSION['ouvrage_image'] = $ouvrage['image'];
} else {

    $_SESSION['global_bibliothecaire_error'] = 'Une action inattendue bloque le processus';
    header('location:' . PROJECT_ROM . 'bibliothecaire/ouvrages/listes_ouvrages');
    exit;
}

?>

<section class="section dashboard">
    <main id="main" class="main">
        <div class="row">

            <?php

            if (!empty($_SESSION['modifier_ouvrage_errors'])) {
                $erreurs = $_SESSION['modifier_ouvrage_errors'];
            }

            if (!empty($_SESSION['data'])) {
                $data = $_SESSION['data'];
            }

            ?>

            <div class="col-md-6">
                <h1>Modifier un ouvrage</h1>
            </div>

            <div class="col-md-6 text-end bibliotheque-list-add-btn">
                <a href="listes_ouvrages" class="btn btn-primary">Liste des ouvrages</a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 bd-example">
                <form action="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/traitement_modifier_ouvrage" method="post" enctype="multipart/form-data">

                    <div class="container">

                        <div class="col-md-12">
                            <label for="titre-ouvrage" class="form-label">Titre :</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control <?= !empty($erreurs['titre_ouvrage']) ? 'is-invalid' : '' ?>" id="titre-ouvrage" value="<?= !empty($data['titre_ouvrage']) ? $data['titre_ouvrage'] : $ouvrage['titre'] ?>" name="titre_ouvrage" placeholder="Veuillez entrer le titre de l'ouvrage">
                            <?php if (!empty($erreurs['titre_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['titre_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="nombre-exemplaire-ouvrage" class="form-label">Nombre d'exemplaire :</label>
                            <span class="text-danger">*</span>
                            <input type="number" class="form-control <?= !empty($erreurs['nombre_exemplaire_ouvrage']) ? 'is-invalid' : '' ?>" id="nombre-exemplaire-ouvrage" value="<?= !empty($data['nombre_exemplaire_ouvrage']) ? $data['nombre_exemplaire_ouvrage'] : $ouvrage['nb_ex'] ?>" name="nombre_exemplaire_ouvrage">
                            <?php if (!empty($erreurs['nombre_exemplaire_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['nombre_exemplaire_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="auteur-principal-ouvrage" class="form-label">Auteur principal :</label>
                            <span class="text-danger">*</span>
                            <select class="form-select <?= isset($erreurs['auteur_principal_ouvrage']) ? 'is-invalid' : '' ?>" id="auteur-principal-ouvrage" name="auteur_principal_ouvrage">
                                <option value="0"></option>
                                <?php
                                // Appeler la fonction pour récupérer la liste des auteurs
                                $liste_auteurs = get_liste_auteurs();

                                // Afficher les auteurs dans le menu déroulant
                                foreach ($liste_auteurs as $auteur) {

                                ?>

                                    <option value="<?= $auteur['num_aut'] ?>" <?php if (!empty($data['auteur_principal_ouvrage']) && $data['auteur_principal_ouvrage'] == $auteur['num_aut']) {
                                                                                    echo 'selected';
                                                                                } elseif ($ouvrage['num_aut'] == $auteur['num_aut']) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                        <?= $auteur['nom_aut'] . ' ' . $auteur['prenoms_aut'] ?>
                                    </option>

                                <?php
                                }
                                ?>
                            </select>
                            <?php if (isset($erreurs['auteur_principal_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['auteur_principal_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="langue-ouvrage" class="form-label">Langue :</label>
                            <span class="text-danger">*</span>
                            <select class="form-select <?= isset($erreurs['langue_ouvrage']) ? 'is-invalid' : '' ?>" id="langue-ouvrage" name="langue_ouvrage">
                                <option value="0"></option>
                                <?php
                                // Appeler la fonction pour récupérer la liste des langues
                                $liste_langue = get_liste_langue();

                                // Afficher les langues dans le menu déroulant
                                foreach ($liste_langue as $langue_item) {

                                ?>

                                    <option value="<?= $langue_item['cod_lang'] ?>" <?php if (!empty($data['langue_ouvrage']) && $data['langue_ouvrage'] == $langue_item['cod_lang']) {
                                                                                        echo 'selected';
                                                                                    } elseif ($cod_lang_ouvrage == $langue_item['cod_lang']) {
                                                                                        echo 'selected';
                                                                                    } ?>>
                                        <?= $langue_item['lib_lang'] ?>
                                    </option>

                                <?php
                                }
                                ?>
                            </select>
                            <?php if (isset($erreurs['langue_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['langue_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="annee-publication" class="form-label">Année de publication :</label>
                            <span class="text-danger">*</span>
                            <input type="number" class="form-control <?= isset($erreurs['annee_publication']) ? 'is-invalid' : '' ?>" id="annee-publication" value="<?= !empty($data['annee_publication']) ? $data['annee_publication'] : $ouvrage['periodicite'] ?>" name="annee_publication">
                            <?php if (isset($erreurs['annee_publication'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['annee_publication'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="image-ouvrage" class="form-label">Image de la page de garde:</label>
                            <span class="text-danger">*</span>
                            <div class="d-flex justify-content-center mb-2">
                                <img class="resizable-image" src="<?= $ouvrage['image'] ?>" alt="">
                            </div>
                            <input type="file" accept=".jpg,.jpeg,.png,.gif,.webp" class="form-control <?= isset($erreurs['image_ouvrage']) ? 'is-invalid' : '' ?>" id="image-ouvrage" name="image_ouvrage">
                            <?php if (isset($erreurs['image_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['image_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12">
                            <label for="auteurs-secondaires-ouvrage" class="form-label">Auteurs secondaires :</label>
                            <select class="form-select select2bs4 <?= isset($erreurs['auteurs_secondaires_ouvrage']) ? 'is-invalid' : '' ?>" id="auteurs-secondaires-ouvrage" name="auteurs_secondaires_ouvrage[]" multiple>
                                <option value="0"></option>
                                <?php
                                // Appeler la fonction pour récupérer la liste des auteurs
                                $liste_auteurs = get_liste_auteurs();
                                // Afficher les auteurs dans le menu déroulant
                                foreach ($liste_auteurs as $auteur) {
                                ?>
                                    <option value="<?= $auteur['num_aut'] ?>" <?php
                                                                                echo (!empty($data['auteurs_secondaires_ouvrage']) && in_array($auteur['num_aut'], $data['auteurs_secondaires_ouvrage'])) || in_array($auteur['num_aut'], $num_aut_secondaires) ? 'selected' : '' ?>><?= $auteur['nom_aut'] . ' ' . $auteur['prenoms_aut'] ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php if (isset($erreurs['auteurs_secondaires_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['auteurs_secondaires_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="domaineListe" class="form-label">Domaine :</label>
                            <span class="text-danger">*</span>
                            <select class="form-select select2bs4 <?= isset($erreurs['domaine_ouvrage']) ? 'is-invalid' : '' ?>" id="domaineListe" name="domaine_ouvrage[]" onchange="updateCategories()" multiple>
                                <option value="0"></option>
                                <?php
                                // Appeler la fonction pour récupérer la liste des domaines
                                $liste_domaine = get_liste_domaine();
                                // Afficher les domaines dans le menu déroulant
                                foreach ($liste_domaine as $domaine_item) {
                                ?>
                                    <option value="<?= $domaine_item['cod_dom'] ?>" <?php echo (!empty($data['domaine_ouvrage']) && in_array($domaine_item['cod_dom'], $data['domaine_ouvrage'])) || in_array($domaine_item['cod_dom'], $num_doms) ? 'selected' : '' ?>><?= $domaine_item['lib_dom'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php if (isset($erreurs['domaine_ouvrage'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $erreurs['domaine_ouvrage'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-center mt-3">
                                <button type="submit" class="btn btn-success w-30">
                                    Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </main>
</section>

<script>
    function get_categories_by_domaine(domaine) {
        // Utilisez AJAX pour appeler votre serveur PHP et récupérer les catégories en fonction de l'ID du domaine.
        // Par exemple, vous pouvez utiliser fetch() pour effectuer une requête AJAX.
        // Assurez-vous que votre serveur PHP renvoie les données au format JSON.

        // Exemple de code pour récupérer les catégories :
        fetch('<?= PROJECT_ROM . 'bibliothecaire/ouvrages/recuperer_categorie' ?>?domaine=' + domaine)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Une fois que vous avez récupéré les catégories au format JSON, vous pouvez les utiliser pour générer les options de la liste déroulante des catégories.
                const categorieListe = document.getElementById('categorieListe');
                categorieListe.innerHTML = ''; // Vide la liste déroulante des catégories actuelle.

                // Génère les nouvelles options de la liste déroulante des catégories.
                data.forEach(categorie => {
                    const option = document.createElement('option');
                    option.value = categorie.cod_cat;
                    option.textContent = categorie.nom_cat;
                    categorieListe.appendChild(option);
                });
            })
            .catch(error => console.error('Erreur lors de la récupération des catégories :', error));
    }

    function updateCategories() {
        // Récupère l'ID du domaine sélectionné dans la liste déroulante des domaines.
        const domaineListe = document.getElementById('domaineListe');
        const domaine = domaineListe.value;

        // Appelle la fonction pour récupérer et mettre à jour les catégories en fonction du domaine sélectionné.
        get_categories_by_domaine(domaine);
    }

    // Assurez-vous que les options des domaines sont chargées avant d'appeler updateCategories() pour la première fois.
    document.addEventListener('DOMContentLoaded', function() {
        const domaineListe = document.getElementById('domaineListe');
        const premierDomaine = domaineListe.options[1].value; // Supposons que le premier domaine a un ID de 1.

        // Appelle updateCategories() pour afficher les catégories du premier domaine par défaut.
        updateCategories();
    });
</script>

<script>
    // Fonction pour ajouter un bloc de champs input
    function addInputBlock() {
        const container = document.getElementById('container');
        const inputBlock = document.querySelector('.input-block').cloneNode(true);

        // Incrémenter les indices de name pour les inputs
        const select2 = inputBlock.querySelectorAll('select');
        select2.forEach((select, index) => {
            if ((index + 1) % 2 === 0) {
                const currentName = select.getAttribute('name');
                const newName = currentName.replace(/\d+/, match => parseInt(match) + 1);
                select.setAttribute('name', newName);
            }
        });

        const select3 = inputBlock.querySelectorAll('select');
        select3.forEach((select, index) => {
            if ((index + 1) % 3 === 0) {
                const currentName = select.getAttribute('name');
                const newName = currentName.replace(/\d+/, match => parseInt(match) + 1);
                select.setAttribute('name', newName);
            }
        });

        // Modifier le bouton pour permettre la suppression
        const addButton = inputBlock.querySelector('.add-btn');
        addButton.textContent = '-';
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
unset($_SESSION['ajout_ouvrage_error'], $_SESSION['ajout_ouvrage_success'], $_SESSION['modifier_ouvrage_errors'], $_SESSION['data']);
?>