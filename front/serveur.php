<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php'; ?>


<section class="serveur flex-grow-1">
    <h1 class="text-center text-white my-5">L'équipe</h1>
    <div class="container">
        <div class="d-flex justify-content-center btn-teams">
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                <label class="btn btn-outline-light text-island rounded-start-4" for="btnradio1">Tous</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                <label class="btn btn-outline-light text-island" for="btnradio2">Admins</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                <label class="btn btn-outline-light text-island" for="btnradio3">Staff/Modos</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off" checked>
                <label class="btn btn-outline-light text-island" for="btnradio4">Développeurs</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
                <label class="btn btn-outline-light text-island" for="btnradio5">Mappers</label>

                <input type="radio" class="btn-check" name="btnradio" id="btnradio6" autocomplete="off">
                <label class="btn btn-outline-light text-island rounded-end-4" for="btnradio6">Helpers</label>
            </div>
        </div>

        <div class="d-flex align-items-center flex-wrap my-5">
            <?php
            for ($i = 1; $i < 10; $i++) { ?>
                <div class="container-avatar-resizable">
                    <div class="text-white">
                        <div class="avatar">
                            <img src="<?= BASE_PATH . 'assets/img/personnage/perso-1.png' ?>" alt="" class="img-fluid">
                        </div>
                        <small>Ceci est ma place!</small>
                    </div>
                </div>
                <div class="container-avatar-resizable">
                    <div class="avatar-hidden"></div>
                </div>
                <div class="container-avatar-resizable">
                    <div class="text-white">
                        <div class="avatar">
                            <img src="<?= BASE_PATH . 'assets/img/personnage/perso-2.png' ?>" alt="" class="img-fluid">
                        </div>
                        <small>Ceci est ma place!</small>
                    </div>
                </div>
                <div class="container-avatar-resizable">
                    <div class="avatar-hidden"></div>
                </div>
                <div class="container-avatar-resizable">
                    <div class="text-white">
                        <div class="avatar">
                            <img src="<?= BASE_PATH . 'assets/img/personnage/perso-3.png' ?>" alt="" class="img-fluid">
                        </div>
                        <small>Ceci est ma place!</small>
                    </div>
                </div>
                <div class="container-avatar-resizable">
                    <div class="avatar-hidden"></div>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="reseaux-sociaux mb-5">
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

<?php require_once '../inc/footer.inc.php'; ?>