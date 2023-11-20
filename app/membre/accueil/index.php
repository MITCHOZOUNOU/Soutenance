<?php

$title = 'Accueil';

$membres = sizeof(stats('utilisateur', 'profil', 'MEMBRE'));

$ouvrages = sizeof(stats('ouvrage'));

$langues = sizeof(stats('langue'));

$emprunts = sizeof(stats('emprumt'));

$auteurs = sizeof(stats('auteur'));

$domaines = sizeof(stats('domaine'));

include("app/commun/header_membre.php")

?>

    <!-- Slides with captions
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="container-fluid carousel-item active">
                <img src="<?= PROJECT_ROM ?>public/images/em.jpg" alt="Slider image 1" style="width: 100%; height: 500px;" />
                <div class="carousel-caption d-md-block">
                    <h1>Bienvenue à la</h1> <br>
                    <h1 style="background-color: #fff; color:#012970;">Bibliothèque Parakou</h1>
                    <h3>Ici, vous pouvez voir la plupart des livres dont nous disposons tout en étant chez vous.</h3><br>
                    <h3 style=color:#012970>Et ce n'est pas tout</h3>
                    <a href="<?= PROJECT_ROM ?>membre/catalogue/index" class="btn btn-primary">Catalogue -></a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= PROJECT_ROM ?>public/images/bi.avif" alt="Slider image 2" style="width: 100%; height: 500px;" />
                <div class="carousel-caption d-md-block">
                    <h1>Sur notre plateforme, la</h1> <br>
                    <h1 style="color:#012970;">Bibliothèque Parakou</h1>
                    <h3 style="background-color: #fff; color:#012970;">vous donne la possibilité de vous inscrire tous seul en tant que membre <br> afin de bénéficier de tous les avantages qui vont avec.</h3>
                    <a href="<?= PROJECT_ROM ?>membre/catalogue/index" class="btn btn-primary">Catalogue -></a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?= PROJECT_ROM ?>public/images/nn.webp" alt="Slider image 3" style="width: 100%; height: 500px;" />
                <div class="carousel-caption d-md-block">
                    <h1>Avec notre plateforme,</h1>
                    <h3 style="background-color: #fff; color:#012970;">Les emprunts deviennent encore plus facile.</h3>
                    <a href="<?= PROJECT_ROM ?>membre/catalogue/index" class="btn btn-primary">Catalogue -></a>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    </div>
    End Slides with captions -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex justify-cntent-center align-items-center">
        <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

            <!-- Slide 1 -->
            <div class="carousel-item active mt-5">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Bienvenue à la Bibliothèque de <span>Parakou </span></h2>
                    <p class="animate__animated animate__fadeInUp">
                        Nous sommes ravis de vous accueillir dans notre bibliothèque, un lieu dédié
                        à l'épanouissement intellectuel, à la découverte et à l'inspiration. Chez nous,
                        la connaissance est à portée de main, et chaque visite est une aventure.</p>
                    <a href="<?= PROJECT_ROM ?>membre/catalogue/index" class="btn-get-started animate__animated animate__fadeInUp scrollto">Catalogue</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item mt-5">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Bienvenue à la Bibliothèque de <span>Parakou </span></h2>
                    <p class="animate__animated animate__fadeInUp">
                        Que vous soyez un passionné de lecture,
                        un étudiant en quête de ressources éducatives,
                        ou simplement quelqu'un qui souhaite explorer le monde à travers les mots,
                        vous trouverez ici un espace chaleureux où les portes de la curiosité sont toujours ouvertes.

                    </p>
                    <a href="<?= PROJECT_ROM ?>membre/catalogue/index" class="btn-get-started animate__animated animate__fadeInUp scrollto">Catalogue</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item mt-5">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Bienvenue à la Bibliothèque de <span>Parakou </span></h2>
                    <p class="animate__animated animate__fadeInUp">Nos services variés, notre équipe dévouée
                        et notre collection riche sont à votre disposition pour vous accompagner dans votre voyage intellectuel.
                        N'hésitez pas à explorer nos rayons, participer à nos événements culturels et profiter de tout ce que la Bibliothèque
                        de Parakou a à offrir.<br>
                        Que ce soit pour vous divertir, apprendre, ou tout simplement vous détendre, la Bibliothèque de Parakou est l'endroit où vous pouvez le faire. Bienvenue, et que votre aventure littéraire commence ici !</p>
                    </p>

                    <a href="<?= PROJECT_ROM ?>membre/catalogue/index" class="btn-get-started animate__animated animate__fadeInUp scrollto">Catalogue</a>
                </div>
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bx bx-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bx bx-chevron-right" aria-hidden="true"></span>
            </a>

        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Icon Boxes Section ======= -->
        <section id="icon-boxes" class="icon-boxes">
            <div class="container">

                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="fade-up">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bxl-dribbble"></i></div>
                            <h4 class="title"><a href="">Prêt de Livres et de Ressources Éducatives</a></h4>
                            <p class="description">
                                Empruntez des livres, des revues, des magazines, des DVD et d'autres ressources éducatives
                                de notre collection diversifiée etc...

                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4 class="title"><a href="">Accès à Internet et aux Ordinateurs</a></h4>
                            <p class="description">
                                La bibliothèque offre un accès à Internet gratuit ainsi que des ordinateurs pour la recherche,
                                etc.....
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <h4 class="title"><a href="">Club de Lecture</a></h4>
                            <p class="description">

                                Rejoignez notre club de lecture pour partager vos réflexions sur
                                des livres passionnants avec d'autres amateurs etc....</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box">
                            <div class="icon"><i class="bx bx-layer"></i></div>
                            <h4 class="title"><a href="">Conférences, Débats et Événements Culturels</a></h4>
                            <p class="description">
                                La bibliothèque organise régulièrement des conférences, des débats et des événements culturels etc...
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Icon Boxes Section -->

        <!-- ======= Stats Section ======= -->
        <section id="team" class="team">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Statistiques</h2>
                    <p>Données informatives</p>
                </div>

                <div class="row" data-aos="fade-left">

                    <div class="col-lg-3 col-md-6">
                        <div class="member" data-aos="zoom-in" data-aos-delay="100">
                            <div class="pic"><img src="<?= PROJECT_ROM ?>public/images/ouv.png" class="img-fluid" alt=""></div>
                            <div class="member-info mu-single-counter">
                                <h4>Ouvrages</h4>
                                <span class="counter-value" data-count="<?= $ouvrages ?>">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                        <div class="member" data-aos="zoom-in" data-aos-delay="200">
                            <div class="pic"><img src="<?= PROJECT_ROM ?>public/images/lan.png" class="img-fluid" alt=""></div>
                            <div class="member-info mu-single-counter">
                                <h4>Langues</h4>
                                <span class="counter-value" data-count="<?= $langues ?>">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="member" data-aos="zoom-in" data-aos-delay="300">
                            <div class="pic"><img src="<?= PROJECT_ROM ?>public/images/mem.png" class="img-fluid" alt=""></div>
                            <div class="member-info mu-single-counter">
                                <h4>Membres</h4>
                                <span class="counter-value" data-count="<?= $membres ?>">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="member" data-aos="zoom-in" data-aos-delay="400">
                            <div class="pic"><img src="<?= PROJECT_ROM ?>public/images/emp.png" class="img-fluid" alt=""></div>
                            <div class="member-info mu-single-counter">
                                <h4>Emprunts</h4>
                                <span class="counter-value" data-count="<?= $emprunts ?>">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="member" data-aos="zoom-in" data-aos-delay="400">
                            <div class="pic"><img src="<?= PROJECT_ROM ?>public/images/dom.png" class="img-fluid" alt=""></div>
                            <div class="member-info mu-single-counter">
                                <h4>Domaines</h4>
                                <span class="counter-value" data-count="<?= $domaines ?>">0</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="member" data-aos="zoom-in" data-aos-delay="400">
                            <div class="pic"><img src="<?= PROJECT_ROM ?>public/images/aut.png" class="img-fluid" alt=""></div>
                            <div class="member-info mu-single-counter">
                                <h4>Auteurs</h4>
                                <span class="counter-value" data-count="<?= $auteurs ?>">0</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Stats Section -->

    </main>
    <!-- End #main -->

    <?php
    include("./app/commun/footer_membre.php")

    ?>