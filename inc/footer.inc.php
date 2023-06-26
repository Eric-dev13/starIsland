        </main>
        <footer class="d-flex justify-content-between align-items-center bottom-0 w-100 px-5 py-3 bg-primary">
            <div class="d-flex align-items-center text-white">
                <i class="far fa-envelope fa-2x text-island"></i>
                <div class="fs-4 ps-2">
                    Contact
                </div>
            </div>
            <div>
                <img src="<?= BASE_PATH . 'assets/img/icon/PEGI18.png' ?>" alt="" class="me-2">
                <img src="<?= BASE_PATH . 'assets/img/icon/gta5.png' ?>" alt="" class="">
            </div>
        </footer>


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