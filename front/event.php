<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php'; ?>


<section class="event flex-grow-1 d-flex">
    <div class="container flex-grow-1 d-flex flex-column justify-content-between">
        <div class="row flex-grow-1 justify-content-center align-items-center mt-5">
            <div class="d-none d-sm-block mt-5 col-sm-10 col-md-6 mt-md-0">
                <img src="<?= BASE_PATH . 'assets/img/casino.jpg' ?>" alt="" class="img-fluid rounded">
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
                <h2 class="text-light">Titre</h2>
                <p class="text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur aliquid dolore eos voluptates illo. Autem deleniti, doloribus corporis magni rem excepturi eum blanditiis pariatur inventore quasi neque ducimus consequuntur beatae.</p>
            </div>
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