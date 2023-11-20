
<footer>
<footer class="footer" style="justify-content: center;">
  <h5>&copy;2023 Bibliothèque de Parakou</h5>
</footer>


<!-- CoreUI and necessary plugins-->
<script src="<?= PROJECT_ROM ?>public/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/vendors/simplebar/js/simplebar.min.js"></script>
<!-- Plugins and scripts required by this view-->
<script src="<?= PROJECT_ROM ?>public/vendors/chart.js/js/chart.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
<script src="<?= PROJECT_ROM ?>public/vendors/@coreui/utils/js/coreui-utils.js"></script>
<script src="<?= PROJECT_ROM ?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= PROJECT_ROM ?>public/js/main.js"></script>

</body>
<script src="<?= PROJECT_ROM ?>public/select2/js/select2.full.js"></script>
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
</html>