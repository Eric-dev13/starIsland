<?php
require_once '../config/function.php';




// isSubmitted()
if (!empty($_POST)) {
    $error = false;

    if (empty($_POST['title_page'])) {
        $pages_error = 'Veuillez saisir un titre de page !';
        $error = true;
    }

    if (empty($_POST['url_page'])) {
        $pages_error = 'Veuillez saisir une URL !';
        $error = true;
    }

    if (!$error) {
        // Modification une page
        if (!empty($_POST['id_page'])) {
            $success = execute("UPDATE page SET title_page = :title_page, url_page = :url_page WHERE id_page=:id", array(
                ':id' => $_POST['id_page'],
                ':title_page' => $_POST['title_page'],
                ':url_page' => $_POST['url_page']
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'La page a été modifé.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./page.php');
            exit();
        } else {
            $success = execute("INSERT INTO page (title_page, url_page) VALUES (:title_page, :url_page)", array(
                ':title_page' => $_POST['title_page'],
                ':url_page' => $_POST['url_page'],
            ), false);

            if ($success) {
                $_SESSION['messages']['success'][] = 'Nouveau type de média ajouté.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./page.php');
            exit();
        }
    }
}

// récupère le sous titre de la page d'accueil
$pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_GET)) {
    // Recupère une page pour la gestion de l'édition
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $pageById = execute("SELECT * FROM page WHERE id_page=:id", array(
            ':id' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression de page
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $success = execute("DELETE FROM page WHERE id_page=:id", array(
            ':id' => $_GET['i']
        ));

        if ($success) {
            $_SESSION['messages']['success'][] = 'Page supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./page.php');
        exit();
    }
}

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion des pages</h1>

    <!-- Formulaire pour ajouter un type de média -->
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-lg-6 p-3">
            <div class="bg-light shadow rounded p-3">
                <div class="d-flex mb-3">
                    <?php if (isset($pageById) && !empty($pageById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h4>Editer la page</h4>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h4>Nouvelle page</h4>
                    <?php } ?>
                </div>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Nom</label>
                        <input type="text" name="title_page" class="form-control" id="title_page" value="<?= $pageById['title_page'] ?? '' ?>">
                        <small class="text-danger"><?= $pages_error  ?? ""; ?></small>

                        <label for="mediaType" class="form-label">URI</label>
                        <input type="text" name="url_page" class="form-control" id="url_page" value="<?= $pageById['url_page'] ?? '' ?>">
                        <small class="text-danger"><?= $url_error  ?? ""; ?></small>

                        <input name="id_page" value="<?= $pageById['id_page'] ?? '' ?>" type="hidden">
                    </div>

                    <div class="d-flex">
                        <?php if (isset($pageById) && !empty($pageById)) { ?>
                            <button type="submit" class="btn btn-outline-success me-2">Editer</button>
                            <a class="btn btn-outline-secondary" href="<?= BASE_PATH . 'back/page.php' ?>">
                                Annuler
                            </a>
                        <?php } else { ?>
                            <button type="submit" class="btn btn-outline-primary">Ajouter</button>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- LISTE MEDIA EN TABLEAU -->
        <div class="col-12 col-lg-6 p-3">
            <div class="bg-light shadow rounded p-3">

                <div class="d-flex mb-3">
                    <i class="fas fa-scroll fa-2x text-success me-2"></i>
                    <h4 class="mb-3">Pages existantes</h4>
                </div>

                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre de la page</th>
                            <th scope="col">URL</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($pages as $key => $value) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $value['title_page'] ?></td>
                                <td><?= $value['url_page'] ?></td>
                                <td class="d-flex">
                                    <a href="<?= BASE_PATH . 'back/page.php?a=edit&i=' . $value['id_page']; ?>" class="btn btn-outline-success me-2">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="<?= BASE_PATH . 'back/page.php?a=del&i=' . $value['id_page']; ?>" class="btn btn-outline-danger">
                                        <i class="fas fa-trash-alt fa-1x"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once '../inc/backfooter.inc.php'; ?>