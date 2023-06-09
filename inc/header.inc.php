<?php 

 $arrayActivePage = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
 array_splice($arrayActivePage, 0, 2);
 $activePage = implode('/', $arrayActivePage);

// Renvoie la page courrante
$currentPage = execute("SELECT * FROM page WHERE page.url_page=:url_page",[
                   ':url_page' =>  $activePage
                ])->fetch(PDO::FETCH_ASSOC);

// Reseaux sociaux
$reseauxSociaux = execute("SELECT * FROM page p INNER JOIN media m ON p.id_page=m.id_page INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE p.title_page=:title_page AND mt.title_media_type=:title_media_type ",[
    ':title_media_type' => 'reseauxSociaux',
    ':title_page' => 'ALL'
 ])->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="<?= BASE_PATH . 'assets/fontawesome-free/css/all.min.css' ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= BASE_PATH . 'assets/css/style.css'; ?>">
    <script src="<?= BASE_PATH . 'assets/jquery/jquery.min.js'; ?>"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark font">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_PATH; ?>">
                    <img src="<?= BASE_PATH . 'assets/img/icon/logo_starIsl.png' ?>" alt="logo" width="150">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH; ?>">
                                <img src="<?= BASE_PATH . 'assets/img/icon/home.png' ?>" alt="home" width="30">
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH . 'front/gallerie.php'; ?>">GALLERIE</a>
                        </li>
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH . 'front/vip.php'; ?>">DEVENIR VIP</a>
                        </li>
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH . 'front/team.php'; ?>">TEAM</a>
                        </li>

                        <?php if (connect()) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ADMIN</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= BASE_PATH . 'back/'; ?>">Accès Back-office</a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <div class="navbar-nav d-flex flex-column me-auto">
                        <a class="nav-link" href="<?= BASE_PATH . 'front/tuto.php'; ?>"><img src="<?= BASE_PATH . 'assets/img/icon/btn-1.png' ?>" alt="" width="27" class="me-2">Tutoriel</a>
                        <a class="nav-link" href="<?= BASE_PATH . 'front/event.php'; ?>"><img src="<?= BASE_PATH . 'assets/img/icon/btn-2.png' ?>" alt="" width="27" class="me-2">Evènements</a>
                    </div>

                    <?php if (connect()) : ?>
                        <a href="<?= BASE_PATH . '?a=dis'; ?>" class="btn btn-primary">Déconnexion</a>
                    <?php else :           ?>
                        <a href="<?= BASE_PATH . 'security/login.php'; ?>" class="btn btn-primary">Connexion</a>
                        <?php if (!adminExist()) { ?>
                            <a href="<?= BASE_PATH . 'security/register.php'; ?>" class="btn btn-success">Inscription</a>
                        <?php } ?>
                    <?php endif; ?>

                </div>
            </div>
        </nav>
    </header>
    <main class="d-flex flex-column flex-grow-1 position-relative">

        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) : ?>
            <?php foreach ($_SESSION['messages'] as $type => $messages) : ?>
                <?php foreach ($messages as $key => $message) : ?>
                    <div class="alert alert-<?= $type; ?> position-absolute top-0 start-50 translate-middle z-1 text-center rounded px-5" id="alertCard">
                        <p><?= $message; ?></p>
                    </div>
            <?php unset($_SESSION['messages'][$type][$key]);
                endforeach;
            endforeach;
            ?>
        <?php
        endif;
        ?>