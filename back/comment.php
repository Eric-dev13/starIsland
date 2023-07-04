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
            $success = execute("INSERT INTO comment (rating_comment , comment_text, publish_date_comment, nickname_comment, id_media) VALUES (:rating_comment , :comment_text, :publish_date_comment, :nickname_comment, :id_media)", array(
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


if (!empty($_GET)) {
    // Recupère un contenu pour la gestion de l'édition
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $contentById = execute("SELECT * FROM comment WHERE id_comment =:id_comment ", array(
            ':id_comment ' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression d'un contenu
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $success = execute("DELETE FROM comment WHERE id_comment=:id_comment", array(
            ':id_comment' => $_GET['i']
        ));

        if ($success) {
            $_SESSION['messages']['success'][] = 'Commentaires supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./comment.php');
        exit();
    }

    // Publier / partager
    if (isset($_GET['a']) && $_GET['a'] == 'publish' && isset($_GET['i'])) {
        $success = execute("UPDATE comment SET publish= NOT publish WHERE id_comment =:id_comment", array(
            ':id_comment' => $_GET['i']
        ));
        if ($success) {
            $_SESSION['messages']['success'][] = 'Inverser';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement';
        }

        header('location:./comment.php');
        exit();
    }

    // Suppression d'un contenu
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $success = execute("DELETE FROM comment WHERE id_comment=:id_comment", array(
            ':id_comment' => $_GET['i']
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

// recupère la liste des type de médias
$medias = execute("SELECT * FROM media")->fetchAll(PDO::FETCH_ASSOC);

// recupère les commentaires
$comments = execute("SELECT * FROM comment c LEFT JOIN media m ON c.id_media=m.id_media")->fetchAll(PDO::FETCH_ASSOC);

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion des commentaires</h1>

    <!-- Formulaire pour ajouter du contenu texte -->
    <div class="row justify-content-center mb-3">
        <!-- LISTE MEDIA EN TABLEAU -->
        <div class="col-12 col-lg-10 p-3">
            <div class="bg-light shadow rounded p-3">

                <div class="d-flex mb-3">
                    <i class="fas fa-scroll fa-2x text-success me-2"></i>
                    <h4 class="mb-3">Commentaires</h4>
                </div>

                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date d'édition</th>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Commentaires</th>
                            <th scope="col">Note</th>
                            <th scope="col">Média</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($comments as $key => $comment) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $comment['publish_date_comment'] ?></td>
                                <td><?= $comment['nickname_comment'] ?></td>
                                <td><?= $comment['comment_text'] ?></td>
                                <td>
                                    <div class="d-flex justify-content-around p-2 mt-2">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $comment['rating_comment']) {
                                                echo "<i class='fas fa-star text-warning'></i>";
                                            } else {
                                                echo "<i class='fas fa-star text-dark'></i>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td><?= $comment['title_media'] ?></td>
                                <td>
                                    <?php
                                    if (!$comment['publish']) { ?>
                                        <a href="<?= BASE_PATH . 'back/comment.php?a=publish&i=' . $comment['id_comment']; ?>" class="btn btn-outline-success mb-2" title="Rendre visible ce commentaire">
                                            <i class="fas fa-thumbs-up"></i>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?= BASE_PATH . 'back/comment.php?a=publish&i=' . $comment['id_comment']; ?>" class="btn btn-outline-info mb-2" title="Masquer ce commentaire">
                                            <i class="fas fa-thumbs-down"></i>
                                        </a>
                                    <?php } ?>

                                    <a href="<?= BASE_PATH . 'back/comment.php?a=del&i=' . $comment['id_comment']; ?>" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
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