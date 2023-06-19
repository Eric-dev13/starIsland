<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php'; ?>

<section class="galeriePage">
    <h1 h1 class="text-center text-shadow my-3">Gallerie</h1>
    <div class="row d-flex flex-column align-items-center">

        <!-- <div class="col-12 col-sm-10 col-md-8 col-lg-6 p-3">
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
        </div> -->

        <div class="col-12 col-sm-10 col-md-8 col-lg-6 mt-5">
            <div class="d-flex flex-column justify-content-between align-items-center">
                <div class="rc-container__carousel mb-3">
                    <div class="rc-carousel">
                        <div class="item a"><img src="<?= BASE_PATH . 'assets/img/carrousel/b.jpg' ?>" class="d-block w-100" alt="..."></div>
                        <div class="item b"><img src="<?= BASE_PATH . 'assets/img/carrousel/c.jpg' ?>" class="d-block w-100" alt="..."></div>
                        <div class="item c"><img src="<?= BASE_PATH . 'assets/img/carrousel/d.jpg' ?>" class="d-block w-100" alt="..."></div>
                        <div class="item d"><img src="<?= BASE_PATH . 'assets/img/carrousel/e.jpg' ?>" class="d-block w-100" alt="..."></div>
                        <div class="item e"><img src="<?= BASE_PATH . 'assets/img/carrousel/f.jpg' ?>" class="d-block w-100" alt="..."></div>
                        <div class="item f"><img src="<?= BASE_PATH . 'assets/img/carrousel/d.jpg' ?>" class="d-block w-100" alt="..."></div>
                    </div>
                </div>
                <div class="d-flex justify-content-between w-100 ">
                    <div class="carrousel__next bg-primary bg-opacity-75 rounded p-3"><i class="fas fa-chevron-left fa-2x text-island"></i></div>
                    <div class="carrousel__prev bg-primary bg-opacity-75  rounded p-3"><i class="fas fa-chevron-right fa-2x text-island"></i></div>
                </div>

            </div>
        </div>
    </div>

    <div class="position-absolute d-flex justify-content-between align-items-center bottom-0 w-100 px-4 pb-2">
        <div class="d-flex align-items-center text-white">
            <i class="far fa-envelope fa-2x text-island"></i>
            <div class="fs-4 ps-2">
                Contact
            </div>
        </div>
        <div>
            <img src="<?= BASE_PATH . 'assets/img/PEGI18 1.png' ?>" alt="">
            <img src="<?= BASE_PATH . 'assets/img/gtalogo 1.png' ?>" alt="">
        </div>
    </div>
</section>

<?php require_once '../inc/footer.inc.php'; ?>
<script>

</script>