<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php';

// Recupere les images de la galerie
$galerieImages = execute("SELECT * FROM media m INNER JOIN media_type mt ON m.id_media_type =mt.id_media_type WHERE id_page =:id_page",[
    'id_page' => $currentPage['id_page']
])->fetchAll(PDO::FETCH_ASSOC);
// debug($galerieImages);
?>

<section class="galeriePage flex-grow-1 d-flex flex-column">
    <h1 class="text-center text-shadow my-5">Gallerie</h1>

    <div class="flex-grow-1 row d-flex flex-column align-items-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="d-flex flex-column justify-content-between align-items-center">
                <div class="rc-container__carousel mb-3">
                    <div class="rc-carousel">
                        <?php 
                        // Requete en base pour récupèrer 6 images aléatoirement.                 
                        foreach ($galerieImages as $key => $galerieImage) { ?>
                            <div class="item c<?= $key ?>"><img src="<?= BASE_PATH.'assets/upload/'.$galerieImage['title_media_type'] . '/' . $galerieImage['title_media'] ?>" class="d-block w-100" alt="<?= $galerieImage['name_media'] ?>"></div>
                        <?php }?>
                    </div>
                </div>
                <div class="d-flex justify-content-between w-100 ">
                    <div class="carrousel__next bg-white bg-opacity-75 rounded p-3"><i class="fas fa-chevron-left fa-2x text-island"></i></div>
                    <div class="carrousel__prev bg-white bg-opacity-75  rounded p-3"><i class="fas fa-chevron-right fa-2x text-island"></i></div>
                </div>
            </div>
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
</section>

<!-- CAROUSEL DE LA PAGE GALERIE -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        var carousel = $(".rc-carousel"),
            currdeg = 0;

        $(".carrousel__next").on("click", {
            d: "n"
        }, rotate);
        $(".carrousel__prev").on("click", {
            d: "p"
        }, rotate);

        function rotate(e) {
            if (e.data.d == "n") {
                currdeg = currdeg - 60;
            }
            if (e.data.d == "p") {
                currdeg = currdeg + 60;
            }
            carousel.css({
                "-webkit-transform": "rotateY(" + currdeg + "deg)",
                "-moz-transform": "rotateY(" + currdeg + "deg)",
                "-o-transform": "rotateY(" + currdeg + "deg)",
                "transform": "rotateY(" + currdeg + "deg)"
            });
        }
    });
</script>

<?php require_once '../inc/footer.inc.php'; ?>