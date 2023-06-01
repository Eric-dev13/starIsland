<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaser</title>
    <link rel="stylesheet" href="assets/bootstrap/scss/bootstrap.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/teaser.css">
</head>

<body>
    <main class="d-flex flex-column justify-content-center align-items-center">
        <label class="text-white" id="Compte"></label>

        <div class="reseaux-sociaux">
            <div class="masquer-3">
                <a href="#"><img src="assets/img/reseaux/icons8-home.png" alt="" class="small"></a>
            </div>
            <div class="masquer-2">
                <a href="#"></a>
                <img src="assets/img/reseaux/icons8-facebook.png" alt="" class="small">
            </div>
            <div class="masquer-1">
                <a href="#"><img src="assets/img/reseaux/icons8-tiktok.png" alt="" class="small"></a>
            </div>
            
            <a href="#"><img src="assets/img/reseaux/icons8-discorde.png" alt="" width="70px"></a>

            <div class="masquer-1">
                <a href="#"><img src="assets/img/reseaux/icons8-twitter.png" alt="" class="small"></a>
            </div>
            <div class="masquer-2">
                <a href="#"><img src="assets/img/reseaux/icons8-twitter.png" alt="" class="small"></a>
            </div>
            <div class="masquer-3">
                <a href="#"><img src="assets/img/reseaux/icons8-youtube.png" alt="" class="small"></a>
            </div>
        </div>

    </main>


    <script type="text/javascript">
        var Affiche = document.getElementById("Compte");

        function Rebour() {
            var date1 = new Date();
            var date2 = new Date("jun 30, 2023 00:00:00");
            var sec = (date2 - date1) / 1000;
            var n = 24 * 3600;
            if (sec > 0) {
                j = Math.floor(sec / n);
                h = Math.floor((sec - (j * n)) / 3600);
                mn = Math.floor((sec - ((j * n + h * 3600))) / 60);
                sec = Math.floor(sec - ((j * n + h * 3600 + mn * 60)));
                Affiche.innerHTML = j + " jours " + h + " h " + mn + " m " + sec + " s";
                window.status = "Temps restant : " + j + " j " + h + " h " + mn + " min " + sec + " s ";
            }
            tRebour = setTimeout("Rebour();", 1000);
        }
        Rebour();
    </script>
</body>

</html>