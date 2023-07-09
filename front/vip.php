<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php';

$vips = execute("SELECT * FROM content WHERE id_page=:id_page",[
    ':id_page' => $currentPage['id_page']
])->fetchAll(PDO::FETCH_ASSOC);
// debug($vips);
?>


<section class="vip">
    <h1 class="text-center text-shadow my-5">DEVENIR VIP</h1>

    <div class="container">
        <?php foreach ($vips as $key => $infoVip) { ?>
            <div class="row align-items-center <?php if ($key % 2 == 0) { echo 'flex-row-reverse'; } ?>">
                <div class="col-12 col-sm-7 col-lg-5 <?php if ($key % 2 == 0) { echo 'offset-lg-3'; } else {echo 'd-sm-flex flex-sm-column justify-content-sm-start';} ?> text-white">
                    <h2 class="fw-bold text-island text-center"><?= $infoVip['title_content'] ?></h2>
                    <p class="fs-4 text-center"><?= $infoVip['description_content'] ?></p>
                </div>

                <?php if ($key % 2 == 0) { ?>
                    <div class="d-none col-sm-5 col-lg-4 d-sm-flex flex-sm-column justify-content-sm-end">
                        <img src="<?= BASE_PATH . 'assets/img/perso-2-bordure.png' ?>" class="img-fluid" alt="...">
                    </div>
                <?php } else { ?>
                    <div class="d-none col-sm-5 col-lg-3 offset-lg-2 d-sm-flex flex-sm-column justify-content-sm-start">
                        <img src="<?= BASE_PATH . 'assets/img/perso-1-bordure.png' ?>" class="img-fluid" alt="...">
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <!-- <div class="row">
            <div class="col-12 col-sm-7 col-lg-5 offset-lg-3 text-white">
                <h2 class="fw-bold text-island text-center">VIP</h2>
                <p class="fs-4 text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vitae inventore fugiat illo eveniet consectetur consequatur rerum reiciendis, cupiditate repellendus quam delectus repudiandae quasi quos nam quaerat magni. Quam, dolorem explicabo.</p>
            </div>
            <div class="d-none col-sm-5 col-lg-4 d-sm-flex flex-sm-column justify-content-sm-end">
                <img src="<?= BASE_PATH . 'assets/img/perso-2-bordure.png' ?>" class="img-fluid" alt="...">
            </div>
        </div>

        <div class="row">
            <div class="d-none col-sm-5 col-lg-3 d-sm-flex flex-sm-column justify-content-sm-end">
                <img src="<?= BASE_PATH . 'assets/img/perso-1-bordure.png' ?>" class="img-fluid" alt="...">
            </div>
            <div class="col-12 col-sm-7 col-lg-5 d-sm-flex flex-sm-column justify-content-sm-start text-white">
                <h2 class="fw-bold text-island text-center">VIP</h2>
                <p class="fs-4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Vitae inventore fugiat illo eveniet consectetur consequatur rerum reiciendis, cupiditate repellendus quam delectus repudiandae quasi quos nam quaerat magni. Quam, dolorem explicabo.</p>
            </div>
        </div> -->

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