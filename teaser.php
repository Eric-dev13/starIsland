<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star'island | Teaser</title>
    <link rel="stylesheet" href="assets/bootstrap/scss/bootstrap.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/teaser-first-mobile-1.css">
</head>

<body>
    <div class="gradient"></div>
    <main>
        <div class="timer mx-2">
            <div class="digit">
                <span id="jours"></span>
                <span class="comment">jours</span>
            </div>

            <div class="d-flex flex-column justify-content-center px-1">
                <div class="cercle mb-2"></div>
                <div class="cercle"></div>
            </div>

            <div class="digit">
                <span id="heures"></span>
                <span class="comment">heures</span>
            </div>

            <div class="d-flex flex-column justify-content-center px-1">
                <div class="cercle mb-2"></div>
                <div class="cercle"></div>
            </div>

            <div class="digit">
                <span id="minutes"></span>
                <span class="comment">minutes</span>
            </div>

            <div class="d-flex flex-column justify-content-center px-1">
                <div class="cercle mb-2"></div>
                <div class="cercle"></div>
            </div>

            <div class="digit">
                <span id="secondes"></span>
                <span class="comment">secondes</span>
            </div>
        </div>
        
        <div class="reseaux-sociaux">
            <a id="facebook" class="reseaux facebook" href="">
                <img src="assets/img/reseaux/logo_facebook.png" alt="facebook">
            </a>
            <a id="tiktok" class="reseaux" href="">
                <img src="assets/img/reseaux/Logo_tiktok.png" alt="tiktok">
            </a>
            <a id="twitter" class="reseaux" href="">
                <img src="assets/img/reseaux/logo_twitter.png" alt="twitter">
            </a>
            <a id="youtube" class="reseaux" href="">
                <img src="assets/img/reseaux/logo_youtube.png" alt="youtube">
            </a>
            <a id="twitch" class="reseaux" href="">
                <img src="assets/img/reseaux/logo_twitch.png" alt="logo_twitch">
            </a>
            <a id="instagram" class="reseaux" href="">
                <img src="assets/img/reseaux/logo_Instagram.png" alt="instagram">
            </a>
            <div id="discorde" class="reseaux">
                <img src="assets/img/reseaux/icons8-discorde.png" alt="discorde">
            </div>
        </div>
    </main>

    <script src="assets/js/teaser.js"></script>

    <script type="text/javascript">
        let jours = document.getElementById("jours");
        let heures = document.getElementById("heures");
        let minutes = document.getElementById("minutes");
        let secondes = document.getElementById("secondes");

        function Rebour() {
            var date1 = new Date();
            var date2 = new Date("jun 30, 2023 15:10:00");
            var sec = (date2 - date1) / 1000;
            var n = 24 * 3600;
            if (sec > 0) {
                j = Math.floor(sec / n);
                h = Math.floor((sec - (j * n)) / 3600);
                mn = Math.floor((sec - ((j * n + h * 3600))) / 60);
                sec = Math.floor(sec - ((j * n + h * 3600 + mn * 60)));

                jours.innerHTML = j < 10 ? '0' + j : j;
                heures.innerHTML = h < 10 ? '0' + h : h;
                minutes.innerHTML = mn < 10 ? '0' + mn : mn;
                secondes.innerHTML = sec < 10 ? '0' + sec : sec;

                window.status = sec;

            }
            tRebour = setTimeout("Rebour();", 1000);
        }
        Rebour();
    </script>
</body>

</html>