        </main>
        <footer class="d-flex justify-content-between align-items-center bottom-0 w-100 px-5 py-3 bg-primary">
            <div class="d-flex align-items-center text-white">
                <i class="far fa-envelope fa-2x text-island"></i>
                <div class="fs-4 ps-2">
                    Contact
                </div>
            </div>
            <div>
                <img src="<?= BASE_PATH . 'assets/img/PEGI18 1.png' ?>" alt="" class="me-2">
                <img src="<?= BASE_PATH . 'assets/img/gtalogo 1.png' ?>" alt="" class="">
            </div>
        </footer>

        
        <script src="<?= BASE_PATH . 'assets/js/teaser-cesaire.js' ?>"></script>

        <script>
            const redirectToHomePage = () => {
                document.location.href = "http://localhost/starIsland/home.php";
            }

            $(function() {
                var note = $('#note'),
                    ts = new Date(2023, 05, 30, 00, 00, 00),
                    newYear = true;

                if ((new Date()) > ts) {
                    redirectToHomePage();
                    // ts = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000;
                    // newYear = false;
                }

                $('#countdown').countdown({
                    timestamp: ts,
                    callback: function(days, hours, minutes, seconds) {}
                });

            });
        </script>

        <script src="<?= BASE_PATH . 'assets/js/carrousel-3d.js' ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
