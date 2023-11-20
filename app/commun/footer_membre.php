<!-- ======= Footer ======= -->
<footer id="footer">

  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Liens utiles</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="<?= PROJECT_ROM ?>membre/accueil">Accueil</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="<?= PROJECT_ROM ?>membre/services">A Propos</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="<?= PROJECT_ROM ?>membre/apropos">Services</a></li>

          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Nos Services</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Accès à Internet et aux Ordinateurs</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Conférences, Débats et Événements Culturels</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Ateliers de Lecture et d'Écriture</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Club de Lecture</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 footer-contact">
          <h4>Contactez Nous</h4>
          <p>
            Bénin <br>
            Parakou, <br>
            Zongo <br><br>
            <strong>Téléphone:</strong> +229 89 55 88 55<br>
            <strong>Email:</strong> bibliothequeparakou@gmail.com<br>
          </p>

        </div>

        <div class="col-lg-3 col-md-6 footer-info">
          <h3>A Propos Bibliothèque</h3>
          <p>Bienvenue à la Bibliothèque de Parakou, un lieu dédié à la découverte,
            à l'apprentissage et à la communauté. Notre bibliothèque est un trésor de connaissances
            au cœur de la ville de Parakou, où les rêves prennent vie à travers la lecture, la recherche et la créativité.</p>
          <div class="social-links mt-3">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="copyright">
    &copy; Copyright <strong><span>Bibliothèque Parakou</span></strong>. Tous droits réservés.
  </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


<!-- CoreUI and necessary plugins-->
<script src="<?= PROJECT_ROM ?>public/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/vendors/simplebar/js/simplebar.min.js"></script>
<!-- Plugins and scripts required by this view-->
<script src="<?= PROJECT_ROM ?>public/vendors/@coreui/utils/js/coreui-utils.js"></script>
<script src="<?= PROJECT_ROM ?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/select2/js/select2.full.js"></script>
<script src="<?= PROJECT_ROM ?>public/adminlte.min.js"></script>

<!-- Slick slider -->
<script src="<?= PROJECT_ROM ?>public/assets/js/slick.min.js" type="text/javascript"></script>
<!-- Counter js -->
<script src="<?= PROJECT_ROM ?>public/assets/js/counter.js" type="text/javascript"></script>
<!-- Ajax contact form  -->
<script src="<?= PROJECT_ROM ?>public/assets/js/app.js" type="text/javascript"></script>
<!-- Custom js -->
<script src="<?= PROJECT_ROM ?>public/assets/js/custom.js" type="text/javascript"></script>

<!-- Vendor JS Files -->
<script src="<?= PROJECT_ROM ?>public/assets/vendors/purecounter/purecounter_vanilla.js"></script>
<script src="<?= PROJECT_ROM ?>public/assets/vendors/aos/aos.js"></script>
<script src="<?= PROJECT_ROM ?>public/assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/assets/vendors/glightbox/js/glightbox.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/assets/vendors/isotope-layout/isotope.pkgd.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/assets/vendors/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="<?= PROJECT_ROM ?>public/assets/js/main.js"></script>

<script>
  (function($) {
    $(document).ready(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });
  }(jQuery));
</script>

</body>

</html>