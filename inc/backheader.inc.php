<?php 
// Redirection vers login pour les utilisateurs non authentifié  
if (!connect()){
    header('location:../security/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>StarIsland admin</title>


    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="../assets/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav  text-white sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #000000;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_PATH . 'back/'; ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Star'island Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                gestion
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/page.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Page</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/content.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Contenu</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/mediaType.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Type de média</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/media.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Médias</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/comment.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Commentaires</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/team.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Team</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= BASE_PATH . 'back/event.php' ?>">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Evènements</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link collapsed dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Gestion des pages</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                    <div class="bg-white p-2 collapse-inner rounded">
                        <a class="dropdown-item text-dark" href="#">Page d'accueil</a>
                    </div>
                </div>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                    <div class="bg-white p-2 collapse-inner rounded">
                        <a class="dropdown-item text-dark" href="#">Modifer un média</a>
                    </div>
                </div>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                    <div class="bg-white p-2 collapse-inner rounded">
                        <a class="dropdown-item text-dark" href="#">Supprimer un média</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow" style="background-color: #000000;">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link " href="<?= BASE_PATH; ?>" role="button">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Voir le site</span>
                                <img class="img-profile rounded-circle" src="">
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <div class="container position-relative">
                    <!-- AFFICHAGE DES ERREURS -->
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
                </div>


                <div class="container-fluid">
                    <!-- Page Heading -->