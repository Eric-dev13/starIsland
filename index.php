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
?>


<section class="position-relative homePage bloc-1">
    <div class="strecth-layer-transparent shadow-1"></div>

    <div class="position-absolute w-100 h-100">
        <div class="container d-flex flex-column justify-content-evenly align-items-center h-100">
            <h1 class="text-center text-shadow">BIENVENUE SUR<br>STAR’ISLAND</h1>
            <div class="container-md page-1">
                <p class="text-shadow my-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, cum culpa? Nisi unde
                    quasi culpa. Vitae, molestiae quisquam ea quo repellat eveniet consequuntur enim totam, deserunt ab
                    reprehenderit modi dignissimos?
                </p>
            </div>

            <div class="row d-none justify-content-center page-2">
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

            <div class="row d-none justify-content-center w-100 page-3">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 p-3">
                    <div class="d-flex flex-column bg-white bg-opacity-25 mt-4 px-5 rounded">
                        <h4 class="fw-bold text-center py-3">Star'Island</h4>
                        <div class="d-flex justify-content-around mb-3 px-5">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
                        </div>
                        <textarea name="" id="" cols="10" rows="5" class="mb-3 bg-white bg-opacity-25">Commentaires</textarea>
                        <a href="#" class="btn btn-light mb-3">Publier</a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mb-3">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
            </div>

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
    </div>
</section>

<section class="position-relative homePage bloc-2">
    <div class="strecth-layer-transparent shadow-2"></div>

    <div class="container mt-5">
        <!-- <div class="row mb-3">
            <div class="col-12 col-md-6 d-flex justify-content-center mb-3">
                <div class="avis left d-flex align-items-center border border-dark">
                    <img src="<?= BASE_PATH . 'assets/img/Ellipse_58.png' ?>" alt="" class="ms-3" width=80>
                    <div class="ps-2">
                        <div class="d-flex justify-content-around  mt-2">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
                        </div>
                        <div class="mt-2 text-black">
                            Super serveur GTA RP <br>
                            Publié le 15/05/2023
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="avis right d-flex align-items-center border border-dark">
                    <img src="<?= BASE_PATH . 'assets/img/Ellipse_56.png' ?>" alt="" class="ms-3" width=80>
                    <div class="ps-2">
                        <div class="d-flex justify-content-around mt-2">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
                        </div>
                        <div class="mt-2 text-black">
                            Super serveur GTA RP <br>
                            Publié le 15/05/2023
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 d-flex justify-content-center mb-3">
                <div class="avis left d-flex align-items-center border border-dark">
                    <img src="<?= BASE_PATH . 'assets/img/Ellipse_57.png' ?>" alt="" class="ms-3" width=80>
                    <div class="ps-2">
                        <div class="d-flex justify-content-around  mt-2">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
                        </div>
                        <div class="mt-2 text-black">
                            Super serveur GTA RP <br>
                            Publié le 15/05/2023
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="avis right d-flex align-items-center border border-dark">
                    <img src="<?= BASE_PATH . 'assets/img/Ellipse_59.png' ?>" alt="" class="ms-3" width=80>
                    <div class="ps-2">
                        <div class="d-flex justify-content-around  mt-2">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                            <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
                        </div>
                        <div class="mt-2 text-black">
                            Super serveur GTA RP <br>
                            Publié le 15/05/2023
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="d-flex justify-content-center justify-content-md-start mt-2 mt-lg-0">
            <div class="avis left d-flex align-items-center justify-content-center border border-dark py-2">
                <img src="<?= BASE_PATH . 'assets/img/Ellipse_58.png' ?>" alt="" width=80>
                <div class="ps-2">
                    <div class="d-flex justify-content-around mt-2">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
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
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
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
                    <div class="d-flex justify-content-around  mt-2">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
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
                    <div class="d-flex justify-content-around  mt-2">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                        <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
                    </div>
                    <div class="mt-2 text-black">
                        Super serveur GTA RP <br>
                        Publié le 15/05/2023
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column border bg-white bg-opacity-25 px-5 my-5 rounded">
            <h4 class="text-center py-3">Votre avis nous intéresse</h4>
            <div class="d-flex justify-content-around mb-3 px-5">
                <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                <img src="<?= BASE_PATH . 'assets/img/etoile-1.png' ?>" alt="">
                <img src="<?= BASE_PATH . 'assets/img/etoile.png' ?>" alt="">
            </div>
            <textarea name="" id="" cols="10" rows="5" class="mb-3 bg-white bg-opacity-25">Commentaires</textarea>
            <a href="#" class="btn btn-light mb-3">Publier</a>
        </div>
    </div>
</section>



<?php require_once 'inc/footer.inc.php'; ?>

<script>
    // Boutons de défilement de bloc de page
    const slideX = [{
            transform: `translateX(500px) rotateZ(180deg) scale(0)`
        },
        {
            transform: "translateX(0) rotateZ(0deg) scale(1)"
        },
    ];

    const slideXTiming = {
        // delay: 2,
        duration: 300,
        iterations: 1,
        // easing: "cubic-bezier(0.6, 0.04, 0.98, 0.335)"
    };

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
</script>