<!-- INDEX -->

<?php
require_once 'config/function.php';
require_once 'inc/header.inc.php';

if (isset($_GET['a']) && $_GET['a'] == 'dis') {
    unset($_SESSION['user']);
    $_SESSION['messages']['info'][] = 'A bientôt !!';
    header('location:./');
    exit();
}

// validation des formulaires
if (!empty($_POST)) {
    $avisError = false;
    $topServerError = false;

    // AVIS NOTE si pas de value pour la note alors note est 0
    if (empty($_POST['rating_comment'])) {
        $rating = 0;
    }

    if (empty($_POST['comment_text'])) {
        $avisError = true;
        $avisComment = 'Commentaire obligatoire !';
    }

    if (empty($_POST['nickname_comment'])) {
        $avisError = true;
        $avisPseudo = 'Pseudo obligatoire !';
    }


    // REDIRECT VERS L'API TOP SERVER
    if (empty($_POST['top-server_comment'])) {
        $topServerComment = 'Commentaire obligatoire !';
        $topServerError = true;
    }

    // AVIS NOTE si pas de value pour la note alors note est 0
    if (empty($_POST['top-server_rating'])) {
        $rating = 0;
    }

    if (!$avisError) {
        // Ajouter un contenu
        $success = execute("INSERT INTO comment (rating_comment , comment_text, publish_date_comment, nickname_comment ) VALUES (:rating_comment , :comment_text, :publish_date_comment, :nickname_comment)", array(
            ':rating_comment' => $_POST['rating_comment'],
            ':comment_text' => $_POST['comment_text'],
            ':publish_date_comment' => date("Y-m-d H:i:s"),
            ':nickname_comment' => $_POST['nickname_comment'],
            // ':id_media' => $_POST['id_media'],
        ));

        if ($success) {
            $_SESSION['messages']['success'][] = 'Nouveau contenu ajouté.';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement';
        }

        header('location:./index.php');
        exit();
    }

    if (!$topServerError) {
    }
}


/*
$currentPage[id_page] => 2
$currentPage[title_page] => home
$currentPage[url_page] => /starIsland/
*/

// TITRE DE LA PAGE
$titre = execute("SELECT * FROM content c INNER JOIN page p ON c.id_page = p.id_page WHERE c.id_page=:id_page AND c.title_content = :title_content" ,[
    ':id_page' => $currentPage['id_page'],
    ':title_content' => 'titre'
])->fetch(PDO::FETCH_ASSOC);

// SOUS TITRE
$soustitre = execute("SELECT * FROM content c INNER JOIN page p ON c.id_page = p.id_page WHERE c.id_page=:id_page AND c.title_content = :title_content" ,[
    ':id_page' => $currentPage['id_page'],
    ':title_content' => 'description'
])->fetch(PDO::FETCH_ASSOC);

// COMMENTAIRES récupère les 4 derniers publier et validés par l'admin
$comments = execute("SELECT * FROM comment WHERE comment.publish = 1 ORDER BY id_comment DESC LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);

// Recupere la liste des avatars
$avatars = execute("SELECT * FROM media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type where mt.title_media_type = :avatars",[
    ':avatars' => 'avatars'
])->fetchAll(PDO::FETCH_ASSOC);

// CARROUSEL


$pathCarrousel = BASE_PATH . 'assets/upload/carrouselHome/';
$carousel = execute("SELECT * FROM media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type where mt.title_media_type = :carrouselHome",[
    ':carrouselHome' => 'carrouselHome'
])->fetchAll(PDO::FETCH_ASSOC);

?>


<section class="position-relative homePage bloc-1">
    <div class="strecth-layer-transparent shadow-1"></div>

    <div class="container position-relative">
        <h1 class="text-center text-shadow pt-5"><?= $titre['description_content'] ?></h1>

        <!-- bloc 1 - Présentation  -->
        <div class="row align-items-center px-3 px-md-5 page-1">
            <p class="fs-3 text-shadow"><?= $soustitre['description_content'] ?>
            </p>
        </div>

        <!-- bloc 2 - Carrousel  -->
        <div class="row d-none align-items-center justify-content-center page-2">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 p-3 position-relative">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                    <?php foreach ($carousel as $key => $image) { ?>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $key ?>" <?php if($key == 0) echo "class='active'"; ?> ></button>
                    <?php } ?>
                    </div>
                    <div class="carousel-inner rounded">
                        <?php foreach ($carousel as $key => $image) { ?>
                            <div class="carousel-item <?php if($key == 0 ) echo ' active'; ?>">
                                <img src="<?= $pathCarrousel . $image['title_media'] ?>" class="d-block w-100" alt="<?= $image['name_media'] ?>">
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- bloc 3 - Bloc note et commentaires  --><!-- action="<?= BASE_PATH . 'back/topServer.php'  ?>" -->
        <form action="" class="row d-none align-items-center justify-content-center page-3" method="post" enctype="multipart/form-data">
            <div class="top-server d-flex flex-column bg-light bg-opacity-25 rounded p-3">
                <div class="d-flex justify-content-evenly align-items-center">
                    <div class="top-server--color d-flex flex-column align-items-center">
                        <div class="d-flex">
                            <span>T</span>
                            <img src="<?= BASE_PATH . 'assets/img/icon/topserveur.png' ?>" alt="top-server" width="50">
                            <span>P</span>
                        </div>
                        <P>serveur</P>
                    </div>
                    <h4 class="fw-bold text-center pb-3">Star'Island</h4>
                </div>

                <div class="d-flex justify-content-around mb-1 p-1">
                    <i class="fas fa-star fa-2x top-server__star"></i>
                    <i class="fas fa-star fa-2x top-server__star"></i>
                    <i class="fas fa-star fa-2x top-server__star"></i>
                    <i class="fas fa-star fa-2x top-server__star"></i>
                    <i class="fas fa-star fa-2x top-server__star"></i>
                </div>
                <textarea name="top-server_comment" id="top-server__comment" cols="10" rows="5" class="bg-white bg-opacity-25" placeholder="Commentaires" required></textarea>
                <small class="bg-white bg-opacity-75 text-danger p-2 mb-3"><?= $topServerComment ?? ""; ?></small>
                <input type="hidden" name="top-server_rating" id="top-server_rating">
                <button type="submit" class="btn btn-light mb-3">Publier</button>
            </div>
        </form>

        <!-- Bouton de navigation pour les 3 blocs -->
        <div class="d-flex justify-content-center my-5">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
        </div>

        <!-- Affiche le bouton dépliant des reseaux sociaux -->
        <div class="reseaux-sociaux">
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


<section class="position-relative homePage bloc-2">

    <div class="strecth-layer-transparent shadow-2"></div>

    <div class="container mt-5 position-relative">

            <?php
            foreach ($comments as $key => $comment) {
            ?>
                <div class="row d-flex justify-content-center <?php if ($key % 2) {
                                                                echo "justify-content-md-start";
                                                            } else {
                                                                echo "justify-content-md-end";
                                                            } ?> mb-3 p-2">
                    <div class="col-12 col-md-10 col-lg-8 col-xl-6 bg-light bg-opacity-50 <?php if ($key % 2) {
                                            echo "left";
                                        } else {
                                            echo "right";
                                        } ?> d-flex align-items-center justify-content-center border border-dark p-2">
                        <?php $randomizeAvatar = rand(0, count($avatars)-1); ?>             
                        <img src="<?= BASE_PATH.'assets/upload/avatars/'.$avatars[$randomizeAvatar]['title_media'] ?>" alt="<?= $avatars[$randomizeAvatar]['name_media'] ?>" width=80 class="rounded-circle">
                        <div class="ps-2">
                            <div class="d-flex justify-content-around p-2 mt-2">
                                <?php 
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $comment['rating_comment']) {
                                        echo "<i class='fas fa-star text-sun fa-2x'></i>";
                                    } else {
                                        echo "<i class='fas fa-star text-dark fa-2x'></i>";
                                    }
                                }
                                 ?>
                            </div>
                            <div class="mt-2 text-black">
                                <p><?= $comment['comment_text'] ?></p>
                                <small class="fw-bold">Publié le <?= $comment['publish_date_comment'] ?></small>
                                
                            </div>
                        </div>
                    </div>
                </div>
    <?php } ?>

    <a href="<?= BASE_PATH . 'front/allComment.php' ?>"><h3 class="text-center text-light">Voir tous les commentaires</h3></a>
    
    <hr>

    <form class="d-flex flex-column border bg-white bg-opacity-25 px-5 my-5 rounded" method="post" enctype="multipart/form-data">
        <h4 class="text-center py-3">Votre avis nous intéresse</h4>
        <div class="d-flex justify-content-around mb-3 px-5">
            <i class="fas fa-star fa-3x star-avis"></i>
            <i class="fas fa-star fa-3x star-avis"></i>
            <i class="fas fa-star fa-3x star-avis"></i>
            <i class="fas fa-star fa-3x star-avis"></i>
            <i class="fas fa-star fa-3x star-avis"></i>
        </div>
        <input type="text" name="nickname_comment" class="form-control" id="nickname_comment" placeholder="Pseudo">
        <small class="bg-white bg-opacity-75 text-danger p-2 mb-3"><?= $avisPseudo ?? ""; ?></small>
        <textarea name="comment_text" id="comment_text" cols="10" rows="5" class="bg-white bg-opacity-25" placeholder="Commentaires"></textarea>
        <small class="bg-white bg-opacity-75 text-danger p-2 mb-3"><?= $avisComment ?? ""; ?></small>
        <input type="hidden" name="rating_comment" id="rating_comment">
        <button type="submit" class="btn btn-light mb-3">Publier</button>
    </form>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Gestion des étoiles dans "top server"
        const starsOne = document.querySelectorAll(".fas.fa-star.top-server__star");
        for (let index = 0; index < starsOne.length; index++) {
            starsOne[index].classList.add('text-dark');

            starsOne[index].addEventListener('click', () => {
                for (let i = 0; i < starsOne.length; i++) {
                    if (i <= index) {
                        starsOne[i].classList.remove('text-dark');
                        starsOne[i].classList.add('text-sun');
                        document.getElementById('top-server_rating').value = i + 1;
                    } else {
                        starsOne[i].classList.remove('text-sun');
                        starsOne[i].classList.add('text-dark');
                    }
                }
            });
        }

        // Gestion des étoiles dans "votre avis nous interesse"
        const stars = document.querySelectorAll(".fas.fa-star.star-avis");
        for (let index = 0; index < stars.length; index++) {
            stars[index].classList.add('text-dark');

            stars[index].addEventListener('click', () => {
                for (let i = 0; i < stars.length; i++) {
                    if (i <= index) {
                        stars[i].classList.remove('text-dark');
                        stars[i].classList.add('text-sun');
                        document.getElementById('rating_comment').value = i + 1;
                    } else {
                        stars[i].classList.remove('text-sun');
                        stars[i].classList.add('text-dark');
                    }
                }
            });
        }


        // Boutons de défilement de bloc de page
        const slideX = [{
                transform: `translateX(200px) rotateZ(180deg) scale(0)`
            },
            {
                transform: "translateX(0) rotateZ(360deg) scale(1)"
            },
        ];

        const slideXTiming = {
            // delay: 2,
            duration: 1000,
            iterations: 1,
            easing: "cubic-bezier(0.6, 0.04, 0.98, 0.335)"
        };


        // Affiche et masque les 3 blocs de la première section.
        const circle_1 = document.querySelectorAll('.circle-1');
        for (let index = 0; index < circle_1.length; index++) {
            const element = circle_1[index];
            element.addEventListener('click', () => {
                document.querySelector('.page-1').classList.remove('d-none');
                document.querySelector('.page-1').animate(slideX, slideXTiming);
                document.querySelector('.page-2').classList.add('d-none');
                document.querySelector('.page-3').classList.add('d-none');
            });
        }

        const circle_2 = document.querySelectorAll('.circle-2');
        for (let index = 0; index < circle_2.length; index++) {
            const element = circle_2[index];
            element.addEventListener('click', () => {
                document.querySelector('.page-1').classList.add('d-none');
                document.querySelector('.page-2').classList.remove('d-none');
                document.querySelector('.page-2').animate(slideX, slideXTiming);
                document.querySelector('.page-3').classList.add('d-none');
            });;
        }

        const circle_3 = document.querySelectorAll('.circle-3');
        for (let index = 0; index < circle_3.length; index++) {
            const element = circle_3[index];
            element.addEventListener('click', () => {
                document.querySelector('.page-1').classList.add('d-none');
                document.querySelector('.page-2').classList.add('d-none');
                document.querySelector('.page-3').classList.remove('d-none');
                document.querySelector('.page-3').animate(slideX, slideXTiming);
            });
        }
    });
</script>

<?php require_once 'inc/footer.inc.php'; ?>