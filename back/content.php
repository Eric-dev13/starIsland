<?php
require_once '../config/function.php';


if (!empty($_POST)) {
    $error = false;

    if (empty($_POST['title_content'])) {
        $title_error = 'Veuillez saisir un titre de page !';
        $error = true;
    }

    if (empty($_POST['description_content'])) {
        $description_error = 'Veuillez saisir une URL !';
        $error = true;
    }

    if (!$error) {
        // Modification du contenu
        if (!empty($_POST['id_content'])) {
            $success = execute("UPDATE content SET title_content=:title_content, description_content=:description_content, id_page=:id_page WHERE id_content=:id_content", array(
                ':title_content' => $_POST['title_content'],
                ':description_content' => $_POST['description_content'],
                ':id_page' => $_POST['id_page'],
                ':id_content' => $_POST['id_content']
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'Le contenu a été modifé.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./content.php');
            exit();

        } else {
            // Ajouter un contenu
            $success = execute("INSERT INTO content (title_content , description_content, id_page ) VALUES (:title_content, :description_content, :id_page)", array(
                ':title_content' => $_POST['title_content'],
                ':description_content' => $_POST['description_content'],
                ':id_page' => $_POST['id_page']
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'Nouveau contenu ajouté.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./content.php');
            exit();
        }
    }
}

if (!empty($_GET)) {
    // // EDITER LE CONTENU - Requête pour récupèrer les données du content et l'afficher dans le formulaire
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $contentById = execute("SELECT * FROM content WHERE id_content=:id_content", array(
            ':id_content' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression d'un contenu
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $success = execute("DELETE FROM content WHERE id_content=:id_content", array(
            ':id_content' => $_GET['i']
        ));

        if ($success) {
            $_SESSION['messages']['success'][] = 'Contenu supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./content.php');
        exit();
    }
}


// récupère les pages
$pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);

// récupère les contenus
// $contenus = execute("SELECT * FROM content")->fetchAll(PDO::FETCH_ASSOC);
$contenus = execute("SELECT * FROM content c LEFT JOIN page p ON c.id_page = p.id_page")->fetchAll(PDO::FETCH_ASSOC);


// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion du contenu textuel</h1>

    <!-- Formulaire pour ajouter du contenu texte -->
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-lg-6 p-3">
            <div class="bg-light shadow rounded p-3">
                <div class="d-flex mb-3">
                    <?php if (isset($contentById) && !empty($contentById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h4>Editer le contenu</h4>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h4>Nouveau contenu textuel</h4>
                    <?php } ?>
                </div>

                <form action="" method="post">
                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="title_content" class="form-label">Titre</label>
                        <input type="text" name="title_content" class="form-control" id="title_content" value="<?= $contentById['title_content'] ?? '' ?>">
                        <small class="text-danger"><?= $title_error  ?? ""; ?></small>
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="description_content" class="form-label">Description</label>
                        <textarea name="description_content" class="form-control" id="description_content" rows="3"><?= $contentById['description_content'] ?? '' ?></textarea>
                        <small class="text-danger"><?= $description_error  ?? ""; ?></small>
                        <input name="id_content" value="<?= $contentById['id_content'] ?? '' ?>" type="hidden">
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="id_page">Selection la page</label>
                        <select class="form-select" aria-label="Default select example" name="id_page" id="id_page">
                            <?php
                            foreach ($pages as $key => $page) { ?>
                                <option value="<?= $page['id_page'] ?>" <?php if (isset($contentById) && $contentById['id_page'] == $page['id_page']) {
                                                                            echo ' selected';
                                                                        } ?>> <?= $page['title_page'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-flex">
                        <?php if (isset($contentById) && !empty($contentById)) { ?>
                            <button type="submit" class="btn btn-outline-success me-2">Editer</button>
                            <a class="btn btn-outline-secondary" href="<?= BASE_PATH . 'back/content.php' ?>">
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
        <div class="col-12 p-3">
            <div class="bg-light shadow rounded p-3">

                <div class="d-flex mb-3">
                    <i class="fas fa-scroll fa-2x text-success me-2"></i>
                    <h4 class="mb-3">Contenu</h4>
                </div>

                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Description</th>
                            <th scope="col">Page du contenu</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($contenus as $key => $contenu) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $contenu['title_content'] ?></td>
                                <td><?= $contenu['description_content'] ?></td>
                                <td><?= $contenu['title_page'] ?></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="<?= BASE_PATH . 'back/content.php?a=edit&i=' . $contenu['id_content']; ?>" class="btn btn-outline-success me-2">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="<?= BASE_PATH . 'back/content.php?a=del&i=' . $contenu['id_content']; ?>" class="btn btn-outline-danger">
                                            <i class="fas fa-trash-alt fa-1x"></i>
                                        </a>
                                    </div>
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