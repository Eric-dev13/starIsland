<?php 
// debug($_SERVER['REQUEST_URI']);
// $array = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// $getAllPerPage =  execute("SELECT * FROM page p 
//                 LEFT JOIN content c ON c.id_page=p.id_page  
//                 LEFT JOIN media m ON m.id_page=p.id_page 
//                 LEFT JOIN media_type mt ON mt.id_media_type=m.id_media_type 
//                 LEFT JOIN team_media tm ON tm.id_media=m.id_media 
//                 LEFT JOIN team t ON t.id_team=tm.id_team 
//                 LEFT JOIN event_media em ON em.id_media=m.id_media 
//                 LEFT JOIN event_content ec ON ec.id_content=c.id_content
//                 LEFT JOIN event evtc ON evtc.id_event=ec.id_content
//                 LEFT JOIN event evtm ON evtm.id_event=em.id_media
//                 WHERE p.url_page=:url_page
//                 ",
//                 [
//                    ':url_page' => $_SERVER['REQUEST_URI']
//                 ])->fetchAll(PDO::FETCH_ASSOC);


$currentPage =  execute("SELECT * FROM page WHERE page.url_page=:url_page",[
                   ':url_page' => $_SERVER['REQUEST_URI']
                ])->fetch(PDO::FETCH_ASSOC);
// debug($currentPage);
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
                    <img src="<?= BASE_PATH . 'assets/img/logo_starIsl.png' ?>" alt="logo" width="150">
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