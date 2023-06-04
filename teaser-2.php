<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/bootstrap/scss/bootstrap.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/teaser-first-mobile-2.css">
    <script src="assets/jquery/jquery.min.js"></script>
    <title>Star'island | Teaser</title>
</head>

<body>

    <div class="gradient"></div>

    <main class="d-flex flex-column flex-grow-1 justify-content-between">
        <div class="infos text-white p-4">
            <h1 class="pt-lg-5">Bienvenue sur sur star'Island notre futur serveur de jeu GTA 5</h1>
            <p class="pt-lg-5">Préparez-vous à plonger dans un monde virtuel palpitant, où l'action, l'aventure et la liberté sont les maîtres mots. Notre serveur est conçu pour offrir une expérience de jeu unique à tous les passionnés de GTA 5, qu'ils soient des vétérans chevronnés ou de nouveaux arrivants enthousiastes.</p>
        </div>

        <div id="countdown" class="countdownHolder text-center pt-5 pt-md-0">
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

        <div class="reseaux-sociaux">
            <a id="facebook" class="reseaux facebook" href="https://www.facebook.com/StarIslandfr-108004258577047">
                <img src="assets/img/reseaux/logo_facebook.png" alt="facebook">
            </a>
            <a id="tiktok" class="reseaux" href="https://www.tiktok.com/@star.island?lang=fr">
                <img src="assets/img/reseaux/Logo_tiktok.png" alt="tiktok">
            </a>
            <a id="twitter" class="reseaux" href="https://twitter.com/StarIslandfr">
                <img src="assets/img/reseaux/logo_twitter.png" alt="twitter">
            </a>
            <a id="youtube" class="reseaux" href="https://www.youtube.com/channel/UCI7G6fNN-17g1_tOVMKRCpQ">
                <img src="assets/img/reseaux/logo_youtube.png" alt="youtube">
            </a>
            <a id="twitch" class="reseaux" href="#">
                <img src="assets/img/reseaux/logo_twitch.png" alt="logo_twitch">
            </a>
            <a id="instagram" class="reseaux" href="https://www.instagram.com/starisland.fr/">
                <img src="assets/img/reseaux/logo_Instagram.png" alt="instagram">
            </a>
            <div id="discorde" class="reseaux">
                <img src="assets/img/reseaux/icons8-discorde.png" alt="discorde">
            </div>
        </div>
    </main>


    <script src="assets/js/teaser-cesaire.js"></script>
    <script>
        $(function() {

            var note = $('#note'),
                ts = new Date(2023, 5, 31),
                newYear = true;

            if ((new Date()) > ts) {
                // The new year is here! Count towards something else.
                // Notice the *1000 at the end - time must be in milliseconds
                ts = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000;
                newYear = false;
            }

            $('#countdown').countdown({
                timestamp: ts,
                callback: function(days, hours, minutes, seconds) {}
            });

        });
    </script>
</body>

</html>