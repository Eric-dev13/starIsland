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

<section class="position-relative bloc-1">
    <div class="position-absolute w-100 h-100 opacity-100">
        <div class="container d-flex flex-column justify-content-evenly align-items-center h-100">
            <div class="shadow"></div>
            <h1 class="text-center text-white">BIENVENUE SUR<br>STAR’ISLAND</h1>
            <p class="text-white m-5 border">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, cum culpa? Nisi unde
                quasi culpa. Vitae, molestiae quisquam ea quo repellat eveniet consequuntur enim totam, deserunt ab
                reprehenderit modi dignissimos?
            </p>
            <div class="d-flex justify-content-center mb-3">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
            <div class="text-center">
                <img src="<?= BASE_PATH . 'assets/img/logo_discord.png' ?>" alt="">
            </div>
        </div>
    </div>

    <div class="position-absolute w-100 h-100 opacity-0">
        <div class="d-flex flex-column justify-content-center align-items-center w-90 border border-warning">
            <div class="shadow"></div>
            <h1 class="text-center text-white">BIENVENUE SUR<br>STAR’ISLAND</h1>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="<?= BASE_PATH . 'assets/img/carrousel/a.jpg' ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= BASE_PATH . 'assets/img/carrousel/b.jpeg' ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= BASE_PATH . 'assets/img/carrousel/c.jpg' ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="<?= BASE_PATH . 'assets/img/carrousel/d.jpg' ?>" class="d-block w-100" alt="...">
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

    <div class="position-absolute d-flex flex-column justify-content-evenly align-items-center w-100 h-100 opacity-100 border" style="left:0">
        <div class="shadow"></div>

    </div>

</section>

<section class="position-relative bloc-2">
    <div class="shadow"></div>
    <div class="container mt-5">
        <div class="d-flex justify-content-center justify-content-md-start mt-2 mt-lg-0">
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
        <div class="d-flex justify-content-center justify-content-md-end mt-2 mt-lg-0">
            <div class="avis right d-flex align-items-center border border-dark">
                <img src="<?= BASE_PATH . 'assets/img/Ellipse_56.png' ?>" alt="" class="ms-3" width=80>
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
        <div class="d-flex justify-content-center justify-content-md-start mt-2 mt-lg-0">
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
        <div class="d-flex justify-content-center justify-content-md-end mt-2 mt-lg-0">
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

    </div>

</section>



<?php require_once 'inc/footer.inc.php'; ?>