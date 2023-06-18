<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="<?= BASE_PATH.'assets/css/style.css'; ?>">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_PATH; ?>">
                <img src="<?= BASE_PATH . 'assets/img/logo_starIsl.png' ?>" alt="logo" width="150px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH; ?>">
                                <img src="<?= BASE_PATH . 'assets/img/Vector.png' ?>" alt="home" width="30">
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH.'front/gallerie.php'; ?>">GALLERIE</a>
                        </li>
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH.'front/vip.php'; ?>">DEVENIR VIP</a>
                        </li>
                        <li class="nav-item my-auto">
                            <a class="nav-link" href="<?= BASE_PATH.'front/serveur.php'; ?>">SERVEUR</a>
                        </li>

                        <?php if (admin()) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">ADMIN</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= BASE_PATH . 'back/userList.php'; ?>">Gestion utilisateur</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= BASE_PATH . 'back/'; ?>">Accès Back-office</a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <div class="navbar-nav d-flex flex-column me-auto">
                        <a class="nav-link" href="<?= BASE_PATH.'front/tuto.php'; ?>"><img src="<?= BASE_PATH . 'assets/img/btn-1.png' ?>" alt="" width="27" class="me-2">Tutoriel</a>
                        <a class="nav-link" href="<?= BASE_PATH.'front/event.php'; ?>"><img src="<?= BASE_PATH . 'assets/img/btn-2.png' ?>" alt="" width="27" class="me-2">Evènements</a>
                    </div>

                    <?php if (connect()) : ?>
                        <a href="<?= BASE_PATH . '?a=dis'; ?>" class="btn btn-primary">Déconnexion</a>
                    <?php else :           ?>
                        <a href="<?= BASE_PATH . 'security/login.php'; ?>" class="btn btn-primary">Connexion</a>
                        <a href="<?= BASE_PATH . 'security/register.php'; ?>" class="btn btn-success">Inscription</a>
                    <?php endif; ?>

                </div>
            </div>
        </nav>

    </header>
    <main class="d-flex flex-column">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) : ?>
            <?php foreach ($_SESSION['messages'] as $type => $messages) : ?>
                <?php foreach ($messages as $key => $message) : ?>
                    <div class="alert alert-<?= $type; ?> text-center w-50 mx-auto">
                        <p><?= $message; ?></p>
                    </div>

        <?php unset($_SESSION['messages'][$type][$key]);
                endforeach;
            endforeach;
        endif; ?>