<!DOCTYPE html>

<html lang="fr">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title><?= $title?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= PROJECT_ROM ?>public/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= PROJECT_ROM ?>public/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= PROJECT_ROM ?>public/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= PROJECT_ROM ?>public/assets/favicon/favicon-96x96.png">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="manifest" href="<?= PROJECT_ROM ?>public/assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/css/css.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/css/fontawesome-free/css/all.min.css">
    <!-- Main styles for this application-->
    <link href="<?= PROJECT_ROM ?>public/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism.css">
    <link href="<?= PROJECT_ROM ?>public/css/style.css" rel="stylesheet">
    <link href="<?= PROJECT_ROM ?>public/css/examples.css" rel="stylesheet">

    <link href="<?= PROJECT_ROM ?>public/vendors/@coreui/chartjs/css/coreui-chartjs.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/fontawesome-free/css/all.min.css">

    <!-- Global site tag (gtag.js) - Google Analytics-->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
    <script src="<?= PROJECT_ROM ?>public/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-details').on('click', function() {
                var idMembre = $(this).data('id');
                var modal = $('#modal-details-' + idMembre);

                // Ajoutez les autres informations du membre ici
                var emailMembre = $(this).data('email');
                var adresseMembre = $(this).data('adresse');
                var sexeMembre = $(this).data('sexe');
                var dateNaissanceMembre = $(this).data('date_naissance');
                var telephoneMembre = $(this).data('telephone');

                modal.find('#email-membre').text(emailMembre);
                modal.find('#adresse-membre').text(adresseMembre);
                modal.find('#sexe-membre').text(sexeMembre);
                modal.find('#date-naissance-membre').text(dateNaissanceMembre);
                modal.find('#telephone-membre').text(telephoneMembre);
            });
        });

        // ...
        $(document).ready(function() {
            $('.btn-supprimer').on('click', function() {
                var idMembre = $(this).data('id');

                // Quand on clique sur le bouton "Oui" dans le modal de suppression
                $('#btn-confirmer-suppression').on('click', function() {
                    // Appeler la fonction pour supprimer le compte du membre via AJAX
                    supprimerCompteMembre(idMembre);
                });
            });

            // Fonction pour supprimer le compte du membre via AJAX
            function supprimerCompteMembre(idMembre) {
                $.ajax({
                    url: '<?= PROJECT_ROM ?>bibliothecaire/membres/supprimer_membre_traitement',
                    method: 'POST',
                    data: {
                        id: idMembre
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            // Afficher le message de succès directement sur la page sans utiliser la session
                            alert('La suppression a été effectuée avec succès !');
                            // Rafraîchir la page pour mettre à jour la liste des membres
                            window.location.reload();
                        } else {
                            // Afficher le message d'erreur directement sur la page sans utiliser la session
                            alert(data.message);
                        }
                    },
                    error: function() {
                        // Afficher un message d'erreur en cas d'erreur du serveur
                        alert('Une erreur s\'est produite lors de la suppression. Veuillez réessayer.');
                    }
                });
            }
        });
    </script>
    <style>
        .resizable-image {
            max-width: 700px;
            max-height: 600px;
            width: auto;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">

        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item"><a class="nav-link " class="text-align: center" href="<?= PROJECT_ROM ?>bibliothecaire/dashboard/index">
                    <svg class="nav-icon text-align:left">
                    </svg>
                    <h5 class="text-center">BIBLIOTHEQUE</h5>
                </a>

            </li>
            <li class="nav-title">
                <h6>Tableau de bord</h6>
            </li>
            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-user"></i>&nbsp;
                    <h6>AUTEUR</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/auteur/listes_des_auteurs">
                            <h6>Listes des Auteurs</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/auteur/ajouter_des_auteurs">
                            <h6>Ajouter des Auteurs</h6>
                        </a></li>
                </ul>
            </li>



            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-book"></i>&nbsp;
                    <h6>OUVRAGE</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/listes_ouvrages">
                            <h6>Listes des Ouvrages</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/ajouter_ouvrages">
                            <h6>Ajouter des Ouvrages</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/ouvrages/ouvrages_retourner">
                            <h6>Ouvrages retournés</h6>
                        </a></li>
                </ul>
            </li>

            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-language"></i>&nbsp;
                    <h6>LANGUE</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/langues/listes_des_langues">
                            <h6>Listes des Langues</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/langues/ajouter_langues">
                            <h6>Ajouter des Langues</h6>
                        </a></li>
                </ul>
            </li>

            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-hand-holding"></i>&nbsp;
                    <h6>EMPRUNT</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/emprunts/listes_emprunts">
                            <h6>Listes des Emprunts</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/emprunts/ajouter_emprunts">
                            <h6>Ajouter des Emprunts</h6>
                        </a></li>
                </ul>
            </li>

            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-user-check"></i>&nbsp;
                    <h6>MEMBRE</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/membres/listes_des_membres">
                            <h6>Listes des Membres</h6>
                        </a></li>

                </ul>
            </li>

            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-user-times text-danger"></i>&nbsp;
                    <h6>MEMBRE INDELICAT</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/membres_indelicats/listes_des_membres_indelicats">
                            <h6>Listes indelicats</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/membres_indelicats/ajouter_des_membres_indelicats">
                            <h6>Ajouter indelicats</h6>
                        </a></li>
                </ul>
            </li>

            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                    <i class="fas fa-list-alt"></i>&nbsp;
                    <h6>DOMAINE</h6>
                </a>
                <ul class="nav-group-items">
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/domaines/listes_domaines">
                            <h6>Listes des Domaines</h6>
                        </a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/domaines/ajouter_domaines">
                            <h6>Ajouter des Domaines</h6>
                        </a></li>
                </ul>
            </li>


            <li class="nav-divider"></li>
            <li class="nav-title">
                <h5>Pages</h5>
            </li>

            <li class="nav-item mt-auto"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/dashboard/aide">
                    <i class="fas fa-question-circle"></i>&nbsp;
                    <h6>Aide</h6>
                </a></li>

            <li class="nav-item mt-auto"><a class="nav-link" href="<?= PROJECT_ROM ?>bibliothecaire/dashboard/contact">
                    <i class="fas fa-envelope"></i>&nbsp;
                    <h6>Contact</h6>
                </a></li>


        </ul>
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                </button><a class="header-brand d-md-none" href="#">
                    <svg width="118" height="46" alt="CoreUI Logo">
                        <use xlink:href="<?= PROJECT_ROM ?>"></use>
                    </svg></a>


                <ul class="header-nav ms-3">
                    <li class="nav-item dropdown"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <?= $_SESSION["utilisateur_connecter_bibliothecaire"]['nom'] ?>
                            <?= $_SESSION["utilisateur_connecter_bibliothecaire"]['prenom'] ?>
                            <div class="avatar avatar-md"><img src="<?= $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] == 'no_image' ?  PROJECT_ROM . 'public/images/user.png' : $_SESSION['utilisateur_connecter_bibliothecaire']['avatar'] ?>" style="width: 42px;" alt="Profile" class="rounded-circle" class="img-fluid">

                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="dropdown-header bg-light py-2">
                            </div><a class="dropdown-item" href="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/profil">
                                <h6>Profil</h6>
                            </a>
                            <a class="dropdown-item" href="<?= PROJECT_ROM ?>bibliothecaire/mon_profil/deconnexion">
                                <h6>Déconnexion</h6>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <?php if (!empty($_SESSION['global_bibliothecaire_error'])) : ?>
            <div class="alert alert-danger" style="text-align: center;">
                <?= $_SESSION['global_bibliothecaire_error'] ?>
            </div>
        <?php unset($_SESSION['global_bibliothecaire_error']);
        endif; ?>

        <?php if (!empty($_SESSION['global_bibliothecaire_success'])) : ?>
            <div class="alert alert-success" style="text-align: center;">
                <?= $_SESSION['global_bibliothecaire_success'] ?>
            </div>
        <?php unset($_SESSION['global_bibliothecaire_success']);
        endif; ?>