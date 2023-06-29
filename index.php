<!-- INDEX -->

<?php
require_once 'config/function.php';
require_once 'inc/header.inc.php';

// récupère le sous titre de la page d'accueil
$req ="SELECT c.description_content FROM content c INNER JOIN page p ON c.id_page = p.id_page where p.title_page = :title_page and c.title_content = :title_content";
$homeDescription = execute($req, [
    ':title_page'=>'home', 
    ':title_content'=>'description'
    ])->fetch(PDO::FETCH_ASSOC);


if (isset($_GET['a']) && $_GET['a'] == 'dis') {
    unset($_SESSION['user']);
    $_SESSION['messages']['info'][] = 'A bientôt !!';
    header('location:./');
    exit();
}

// validation des formulaires
// isSubmitted() == !empty($_POST)
if (!empty($_POST)) {
    $error = false;

    var_dump($_POST);

    // AVIS NOTE si pas de value pour la note alors note est 0
    if (empty($_POST['avis_rating'])) {
        $rating = 0;
    } 

    //
    if(empty($POST['avis_comment'])){
        $avisComment = 'Commentaire obligatoire !';
    }

    // REDIRECT VERS L'API TOP SERVER
    if(empty($_POST['top-server_comment'])){
        $topServerComment = 'Commentaire obligatoire !';
        $error = true;
    }

    // AVIS NOTE si pas de value pour la note alors note est 0
    if (empty($_POST['top-server_rating'])) {
        $rating = 0;
    } 

    if (!$error) {
        // request
    }
}
?>


<section class="position-relative homePage bloc-1">
    <div class="strecth-layer-transparent shadow-1"></div>

    <div class="container position-relative">
        <h1 class="text-center text-shadow pt-5">BIENVENUE SUR<br>STAR’ISLAND</h1>

        <!-- bloc 1 - Présentation  -->
        <div class="row align-items-center px-3 px-md-5 page-1">
            <p class="fs-3 text-shadow"><?= $homeDescription["description_content"] ?>
            </p>
        </div>

        <!-- bloc 2 - Carrousel  -->
        <div class="row d-none align-items-center justify-content-center page-2">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 p-3 position-relative">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="<?= BASE_PATH . 'assets/img/carrousel/b.jpg' ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_PATH . 'assets/img/carrousel/c.jpg' ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_PATH . 'assets/img/carrousel/d.jpg' ?>" class="d-block w-100" alt="...">
                        </div>

                        <div class="carousel-item">
                            <img src="<?= BASE_PATH . 'assets/img/carrousel/e.jpg' ?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= BASE_PATH . 'assets/img/carrousel/f.jpg' ?>" class="d-block w-100" alt="...">
                        </div>
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
        <form action="" class="row d-none align-items-center justify-content-center page-3"  method="post" enctype="multipart/form-data">
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
        <div class="d-flex justify-content-center justify-content-md-start mt-2 mt-lg-0">
            <div class="avis left d-flex align-items-center justify-content-center border border-dark py-2">
                <img src="<?= BASE_PATH . 'assets/img/Ellipse_58.png' ?>" alt="" width=80>
                <div class="ps-2">
                    <div class="d-flex justify-content-around mt-2">
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                    </div>
                    <div class="mt-2 text-black">
                        Super serveur GTA RP <br>
                        Publié le 15/05/2023
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center justify-content-md-end mt-2 mt-lg-0">
            <div class="avis right d-flex align-items-center justify-content-center border border-dark py-2">
                <img src="<?= BASE_PATH . 'assets/img/Ellipse_56.png' ?>" alt="" class="ms-3" width=80>
                <div class="ps-2">
                    <div class="d-flex justify-content-around mt-2">
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                    </div>
                    <div class="mt-2 text-black">
                        Super serveur GTA RP <br>
                        Publié le 15/05/2023
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center justify-content-md-start mt-2 mt-lg-0">
            <div class="avis left d-flex align-items-center justify-content-center border border-dark py-2">
                <img src="<?= BASE_PATH . 'assets/img/Ellipse_57.png' ?>" alt="" class="ms-3" width=80>
                <div class="ps-2">
                    <div class="d-flex justify-content-around mt-2">
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                    </div>
                    <div class="mt-2 text-black">
                        Super serveur GTA RP <br>
                        Publié le 15/05/2023
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center justify-content-md-end mt-2 mt-lg-0">
            <div class="avis right d-flex align-items-center justify-content-center border border-dark py-2">
                <img src="<?= BASE_PATH . 'assets/img/Ellipse_59.png' ?>" alt="" class="ms-3" width=80>
                <div class="ps-2">
                    <div class="d-flex justify-content-around mt-2">
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                        <i class="fas fa-star text-dark fa-2x"></i>
                    </div>
                    <div class="mt-2 text-black">
                        Super serveur GTA RP <br>
                        Publié le 15/05/2023
                    </div>
                </div>
            </div>
        </div>

        <form class="d-flex flex-column border bg-white bg-opacity-25 px-5 my-5 rounded" method="post" enctype="multipart/form-data">
            <h4 class="text-center py-3">Votre avis nous intéresse</h4>
            <div class="d-flex justify-content-around mb-3 px-5">
                <i class="fas fa-star fa-3x star"></i>
                <i class="fas fa-star fa-3x star"></i>
                <i class="fas fa-star fa-3x star"></i>
                <i class="fas fa-star fa-3x star"></i>
                <i class="fas fa-star fa-3x star"></i>
            </div>
            <textarea name="avis_comment" id="avis_comment" cols="10" rows="5" class="bg-white bg-opacity-25" placeholder="Commentaires" required></textarea>
            <small class="bg-white bg-opacity-75 text-danger p-2 mb-3"><?= $avisComment ?? ""; ?></small>
            <input type="hidden" name="avis_rating" id="avis_rating">
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
        const stars = document.querySelectorAll(".fas.fa-star.star");
        for (let index = 0; index < stars.length; index++) {
            stars[index].classList.add('text-dark');

            stars[index].addEventListener('click', () => {
                for (let i = 0; i < stars.length; i++) {
                    if (i <= index) {
                        stars[i].classList.remove('text-dark');
                        stars[i].classList.add('text-sun');
                        document.getElementById('avis_rating').value = i + 1;
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