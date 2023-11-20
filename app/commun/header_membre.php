<!DOCTYPE html>

<html lang="fr">

<head>
    <title><?= $title.' - Bibliothèque de Parakou' ?></title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/aos/aos.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/glightbox/css/glightbox.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/remixicon/remixicon.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/vendors/swiper/swiper-bundle.min.css">
    <!-- Main styles for this application-->
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/adminlte.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/css/style.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/css/examples.css">
    <link rel="stylesheet" href="<?= PROJECT_ROM ?>public/assets/css/style.css">

    <link rel="icon" href="<?= PROJECT_ROM ?>public/images/ff.png" type="image/png">

    <script src="<?= PROJECT_ROM ?>public/jquery/jquery.min.js"></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .container {
            position: relative;
            min-height: 100%;
            padding-bottom: 50px;
        }
    </style>

</head>

<header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center justify-content-between">

        <nav id="navbar" class="navbar  fixed-top">
            <div class="logo">
                <!--<h1><a href="<?= PROJECT_ROM ?>membre/accueil"><span>Bibliothèque Parakou</span></a></h1>-->

                <a href="<?= PROJECT_ROM ?>membre/accueil">
                    <img src="<?= PROJECT_ROM ?>public/images/logo-b.png" style="width: 250px;" class="img-fluid" alt="Logo">
                </a>
            </div>
            <ul>
                <li class="nav-item">
                    <a <?php echo (!empty($params[1]) && $params[1] == 'accueil') ? 'style="color: #FFA500;"' : '' ?> href="<?= PROJECT_ROM ?>membre/accueil">Accueil</a>
                </li>
                <li class="nav-item">
                    <a <?php echo (!empty($params[1]) && $params[1] == 'services') ? 'style="color: #FFA500;"' : '' ?> href="<?= PROJECT_ROM ?>membre/services">Services</a>
                </li>
                <li class="nav-item">
                    <a <?php echo (!empty($params[1]) && $params[1] == 'apropos') ? 'style="color: #FFA500;"' : '' ?> href="<?= PROJECT_ROM ?>membre/apropos">A propos</a>
                </li>
                <li class="nav-item">
                    <a <?php echo (!empty($params[1]) && $params[1] == 'contactez-nous') ? 'style="color: #FFA500;"' : '' ?> href="<?= PROJECT_ROM ?>membre/contactez-nous">Contactez-nous</a>
                </li>
                <li class="nav-item">
                    <a <?php echo (!empty($params[1]) && $params[1] == 'catalogue') ? 'style="color: #FFA500;"' : '' ?> href="<?= PROJECT_ROM ?>membre/catalogue/index">Catalogue</a>
                </li>
                <?php
                if (empty($_SESSION['utilisateur_connecter_membre'])) {
                    if (!empty($params[1]) && $params[1] == 'connexion') {
                ?>
                        <li>
                            <a class="btn p-2 mr-4" style="background-color: white; color: #010483;" href="<?= PROJECT_ROM ?>membre/inscription">S'inscrire</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li>
                            <a class="btn p-2 mr-4" style="background-color: white; color: #010483;" href="<?= PROJECT_ROM ?>membre/connexion">Se connecter</a>
                        </li>
                    <?php
                    }
                } else {
                    //die(var_dump($_SESSION['utilisateur_connecter_membre']));
                    ?>
                    <li class="dropdown">
                        <a href="#">
                            <span class="nav-link mr-5">
                                <?= $_SESSION["utilisateur_connecter_membre"]['nom'] . ' ' . $_SESSION["utilisateur_connecter_membre"]['prenom'] . ' ' ?>
                            </span>
                            <span class="avatar avatar-md">
                                <img src="<?= $_SESSION['utilisateur_connecter_membre']['avatar'] == 'no_image' ?  PROJECT_ROM . 'public/images/user.png' : $_SESSION['utilisateur_connecter_membre']['avatar'] ?>" alt="Profile" class="rounded-circle mr-5">
                            </span>
                        </a>
                        <ul>
                            <li>
                                <a href="<?= PROJECT_ROM ?>membre/profil">
                                    Profil
                                </a>
                            </li>
                            <li>
                                <a href=" <?= PROJECT_ROM ?>membre/catalogue/index">
                                    Catalogue
                                </a>
                            </li>
                            <li>
                                <a href="<?= PROJECT_ROM ?>membre/historique_emprunts/index">
                                    Historique d'emprunts
                                </a>
                            </li>
                            <li>
                                <a href="<?= PROJECT_ROM ?>membre/deconnexion">
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->


        
    </div>
</header>

<?php if (!empty($_SESSION['global_membre_error'])) { ?>
    <section class="p-5 p-lg-5"></section>
    <div class="alert alert-danger bg-danger text-center" style="color: white;">
        <?= $_SESSION['global_membre_error'] ?>
    </div>
<?php } ?>

<?php if (!empty($_SESSION['global_membre_success'])) { ?>
    <section class="p-5 p-lg-5"></section>
    <div class="alert alert-success bg-success text-center" style="color: white;">
        <?= $_SESSION['global_membre_success'] ?>
    </div>
<?php } ?>

<?php echo empty($_SESSION['global_membre_error']) && empty($_SESSION['global_membre_success']) ? '<section class="p-lg-4 p-4"></section><section class="p-lg-2 p-2"></section>' : '' ?>

<?php unset($_SESSION['global_membre_error'], $_SESSION['global_membre_success']) ?>