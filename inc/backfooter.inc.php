</div>
<!-- /.container-fluid -->


</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="../assets/jquery/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/jquery-easing/jquery.easing.min.js"></script>
<script src="../assets/js/sb-admin-2.min.js"></script>
<!-- JS BOOTSTRAP -->
<script src="<?= BASE_PATH . 'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js' ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Message d'alerte affiché et a masquer progressivement
        const alertCard = document.getElementById('alertCard');
        if (alertCard !== null) {
            // Définissez le délai en millisecondes (par exemple, 5000 ms pour 5 secondes)
            const delai = 4000;

            // Fonction pour masquer la carte
            function masquerCarte() {
                alertCard.style.transition = "opacity ease-in 0.5s";
                alertCard.style.opacity = "0";
            }

            // Démarrez le délai avec la fonction setTimeout
            setTimeout(masquerCarte, delai);
        }
    });
</script>

</body>


</html>