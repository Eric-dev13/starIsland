<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php';

// OBTENIR LA LISTE DES EVENTS
$event = execute("SELECT * FROM event e LEFT JOIN event_content ec ON e.id_event=ec.id_event 
                                        LEFT JOIN content c ON ec.id_content=c.id_content 
                                        INNER JOIN event_media ev ON e.id_event=ev.id_event 
                                        INNER JOIN media m ON ev.id_media=m.id_media 
                                        INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type
                                        WHERE activate =:activate", [
    'activate' => 1
])->fetch(PDO::FETCH_ASSOC);
// debug($event);

?>


<section class="event flex-grow-1 d-flex">
    <div class="container flex-grow-1 d-flex flex-column justify-content-between">
        <div class="row flex-grow-1 justify-content-center align-items-center mt-5">
            <div class="d-none d-sm-block mt-5 col-sm-10 col-md-6 mt-md-0">
                <img src="<?= BASE_PATH . 'assets/upload/' . $event['title_media_type'] . '/' . $event['title_media'] ?>" alt="<?= $event['name_media'] ?>" class="img-fluid rounded">
                <input type="hidden" value="<?= $event['end_date_event'] ?>" id="dateFin">
            </div>
            <div class="col-11 col-sm-10 col-md-6 bg-light bg-opacity-25 p-3">
                <p class="h2 text-center text-light">TIME REMAINING</p>
                <div class="d-flex justify-content-center mb-3">
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
                <h2 class="text-light"><?= $event['title_content'] ?></h2>
                <p class="text-light"><?= $event['description_content'] ?></p>
            </div>
        </div>

        <div class="reseaux-sociaux my-5">
            <a id="facebook" class="reseaux" href="https://www.facebook.com/StarIslandfr-108004258577047">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_facebook.png' ?>" alt="facebook">
            </a>
            <a id="tiktok" class="reseaux" href="https://www.tiktok.com/@star.island?lang=fr">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/Logo_tiktok.png' ?>" alt="tiktok">
            </a>
            <a id="twitter" class="reseaux" href="https://twitter.com/StarIslandfr">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_twitter.png' ?>" alt="twitter">
            </a>
            <div id="discorde" class="reseaux">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/icons8-discorde.png' ?>" alt="discorde">
            </div>
            <a id="youtube" class="reseaux" href="https://www.youtube.com/channel/UCI7G6fNN-17g1_tOVMKRCpQ">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_youtube.png' ?>" alt="youtube">
            </a>
            <a id="twitch" class="reseaux" href="#">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_twitch.png' ?>" alt="logo_twitch">
            </a>
            <a id="instagram" class="reseaux" href="https://www.instagram.com/starisland.fr/">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_Instagram.png' ?>" alt="instagram">
            </a>
        </div>
    </div>
</section>

<script src="<?= BASE_PATH . 'assets/js/compte-a-rebours.js' ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        let dateFin = document.querySelector("#dateFin").value;
        let currentDate = new Date(dateFin);
        // Retirer un mois à la date
        currentDate.setMonth(currentDate.getMonth() - 1);
        // Obtention des composantes de la nouvelle date
        const year = currentDate.getFullYear();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(currentDate.getDate()).padStart(2, '0');
        const hour = String(currentDate.getHours()).padStart(2, '0');
        const minute = String(currentDate.getMinutes()).padStart(2, '0');
        const second = String(currentDate.getSeconds()).padStart(2, '0');

        // Construire la nouvelle date
        const soustractOneMonthToCurrentDate = `${year}-${month}-${day} ${hour}:${minute}:${second}`;

        let Tab = soustractOneMonthToCurrentDate.split(' ');
        let date = Tab[0].split('-');
        let heure = Tab[1].split(':');
        let df = [...date, ...heure];

        // COMPTE A REBOURS POUR TEASER ET SERVEUR
        $(function() {
            let note = $('#note'),
                // ts = new Date(2023, 07, 30, 00, 00, 00),
                ts = new Date(df[0], df[1], df[2], df[3], df[4], df[5]),
                newYear = true;

            if ((new Date()) > ts) {
                //redirectToHomePage();
                // ts = (new Date()).getTime() + 10 * 24 * 60 * 60 * 1000;
                // newYear = false;
            }

            $('#countdown').countdown({
                timestamp: ts,
                callback: function(days, hours, minutes, seconds) {}
            });
        });
    });
</script>

<?php require_once '../inc/footer.inc.php'; ?>