<!-- TEASER -->

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/bootstrap/scss/bootstrap.css">
    <link rel="stylesheet" href="assets/css/teaser-first-mobile.css">
    <script src="assets/jquery/jquery.min.js"></script>
    <title>Star'island | Teaser</title>
</head>

<body>

    <main class="flex-grow-1 d-flex flex-column text-white">

        <audio id="lecteurAudio" src="assets/sounds/audio.mp3"></audio>
        <div class="audio-island border"><i class="fas fa-volume-up fa-2x"></i></div>

        <div class="flex-grow-1 d-flex align-items-start align-items-lg-center">
            <h1 class="w-100 text-center pt-4 pl-2">Bienvenue sur star'Island</h1>
        </div>

        <div class="flex-grow-1 d-flex justify-content-center justify-content-lg-start align-items-start align-items-lg-end ml-lg-5">
            <div id="countdown" class="countdownHolder text-center">
                <span class="countDays">
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                </span>
                <span class="countDiv countDiv0"></span>
                <span class="countHours">
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                </span>
                <span class="countDiv countDiv1"></span>
                <span class="countMinutes">
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                </span>
                <span class="countDiv countDiv2"></span>
                <span class="countSeconds">
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                    <span class="position">
                        <span class="digit static"></span>
                    </span>
                </span>
            </div>
        </div>

        <div class="flex-grow-1 d-flex justify-content-lg-start align-items-end ml-lg-5">
            <p class="p-3">Découvrez notre serveur GTA 5 gratuit qui réunit une communauté dynamique et passionnée.
                Plongez dans des événements captivants et profitez d'un mode de jeu freetoplay entièrement en français.
                Rejoignez-nous dès maintenant pour une expérience immersive et palpitante dans l'univers de GTA 5, sans
                aucun frais.</p>
        </div>

        <div class="reseaux-sociaux">
            <a id="facebook" class="reseaux" href="https://www.facebook.com/StarIslandfr-108004258577047">
                <img src="assets/img/reseaux/logo_facebook.png" alt="facebook">
            </a>
            <a id="tiktok" class="reseaux" href="https://www.tiktok.com/@star.island?lang=fr">
                <img src="assets/img/reseaux/Logo_tiktok.png" alt="tiktok">
            </a>
            <a id="twitter" class="reseaux" href="https://twitter.com/StarIslandfr">
                <img src="assets/img/reseaux/logo_twitter.png" alt="twitter">
            </a>
            <div id="discorde" class="reseaux">
                <img src="assets/img/reseaux/icons8-discorde.png" alt="discorde">
            </div>
            <a id="youtube" class="reseaux" href="https://www.youtube.com/channel/UCI7G6fNN-17g1_tOVMKRCpQ">
                <img src="assets/img/reseaux/logo_youtube.png" alt="youtube">
            </a>
            <a id="twitch" class="reseaux" href="#">
                <img src="assets/img/reseaux/logo_twitch.png" alt="logo_twitch">
            </a>
            <a id="instagram" class="reseaux" href="https://www.instagram.com/starisland.fr/">
                <img src="assets/img/reseaux/logo_Instagram.png" alt="instagram">
            </a>
        </div>
    </main>


    <script src="assets/js/teaser-cesaire.js"></script>
    <script>
        const audio = document.querySelector("#lecteurAudio");
        const btnAudio = document.querySelector('.audio-island');

        btnAudio.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                btnAudio.innerHTML = '<i class="fas fa-volume-mute fa-2x"></i>';
            } else {
                audio.pause();
                btnAudio.innerHTML = '<i class="fas fa-volume-up fa-2x"></i>';
            }
        });


        const redirectToHomePage = () => {
            document.location.href = "http://localhost/starIsland/home.php";
        }

        $(function () {

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
                callback: function (days, hours, minutes, seconds) { }
            });

        });
    </script>
    
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>