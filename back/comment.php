<?php
require_once '../config/function.php';

if (!empty($_POST)) { 
    $error = false;

    if (empty($_POST['nickname_comment'])) {
        $description_error = 'Veuillez votre speudo !';
        $error = true;
    }

    if (empty($_POST['comment_text'])) {
        $title_error = 'Veuillez saisir un commentaire pour cette page !';
        $error = true;
    }

    if (empty($_POST['rating_comment'])) {
        $description_error = 'Veuillez saisir une note !';
        $error = true;
    }


    if (!$error) {
        // Modification du contenu
        if (!empty($_POST['id_comment '])) {
            $success = execute("UPDATE comment SET rating_comment=:rating_comment, comment_text=:comment_text, publish_date_comment =:publish_date_comment, nickname_comment=:nickname_comment, id_media =:id_media  WHERE id_comment =:id_comment ", array(
                ':rating_comment' => $_POST['rating_comment'],
                ':comment_text' => $_POST['comment_text'],
                ':publish_date_comment' => $_POST['publish_date_comment'],
                ':nickname_comment' => $_POST['nickname_comment'],
                'id_media' => $_POST['id_media'],
                'id_comment' => $_POST['id_comment'],
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'Le commentaire a été modifé.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./content.php');
            exit();
        } else {
            // Ajouter un contenu
            $success = execute("INSERT INTO comment (rating_comment , comment_text, publish_date_comment, nickname_comment, id_media, id_comment ) VALUES (:rating_comment , :comment_text, :publish_date_comment, :nickname_comment, :id_media, :id_comment)", array(
                ':rating_comment' => $_POST['rating_comment'],
                ':comment_text' => $_POST['comment_text'],
                ':publish_date_comment' => $_POST['publish_date_comment'],
                ':nickname_comment' => $_POST['nickname_comment'],
                ':id_media' => $_POST['id_media'],
                ':id_comment' => $_POST['id_comment'],
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

// recupère la liste des type de médias
$medias = execute("SELECT * FROM media")->fetchAll(PDO::FETCH_ASSOC);


if (!empty($_GET)) {
    // Recupère un contenu pour la gestion de l'édition
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $contentById = execute("SELECT * FROM comment WHERE id_comment =:id_comment ", array(
            ':id_comment ' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression d'un contenu
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        execute("DELETE FROM comment WHERE id_comment =:id_comment ", array(
            ':id_comment ' => $_GET['i']
        ));

        if ($success) {
            $_SESSION['messages']['success'][] = 'Commentaires supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./comment.php');
        exit();
    }
}

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion du contenu textuel</h1>

    <!-- Formulaire pour ajouter du contenu texte -->
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-lg-4 p-3">
            <div class="bg-light shadow rounded p-3">
                <div class="d-flex mb-3">
                    <?php if (isset($commentById) && !empty($commentById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h4>Editer ce commentaire</h4>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h4>Nouveau commentaire</h4>
                    <?php } ?>
                </div>

                <form action="" method="post">
                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="comment_text" class="form-label">Commentaire</label>
                        <input type="text" name="comment_text" class="form-control" id="comment_text" value="<?= $contentById['comment_text'] ?? '' ?>">
                        <small class="text-danger"><?= $title_error  ?? ""; ?></small>
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="" class="form-label">Notation</label>
                        <input type="text" name="comment_text" class="form-control" id="comment_text" value="<?= $contentById['comment_text'] ?? '' ?>">
                        <textarea name="rating_comment" class="form-control" id="rating_comment" rows="3"><?= $contentById['rating_comment'] ?? '' ?></textarea>
                        <small class="text-danger"><?= $description_error  ?? ""; ?></small>
                        <input name="id_comment " value="<?= $contentById['id_comment '] ?? '' ?>" type="hidden">
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="id_page">Selectionnez le media</label>
                        <select class="form-select" aria-label="Default select example" name="id_media" id="id_media">
                            <!-- <option selected></option> -->
                            <?php
                            foreach ($pages as $key => $page) { ?>
                                <option value="<?= $page['id_page'] ?>" <?php if(isset($contentById) && $contentById['id_page'] == $page['id_page']){ echo ' selected';} ?> > <?= $page['title_page'] ?></option>
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
        <div class="col-12 col-lg-8 p-3">
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
                                <td><?= getProperty($pages, 'title_page', 'id_page', $contenu['id_page'] ) ?></td>
                                <td class="d-flex">
                                    <a href="<?= BASE_PATH . 'back/content.php?a=edit&i=' . $contenu['id_content']; ?>" class="btn btn-outline-success me-2">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="<?= BASE_PATH . 'back/content.php?a=del&i=' . $contenu['id_content']; ?>" class="btn btn-outline-danger">
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