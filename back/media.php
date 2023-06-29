<?php
require_once '../config/function.php';


if (!empty($_POST)) {
    $error = false;

    if (empty($_POST['title_media'])) {
        $title_error = 'Veuillez saisir le titre du média !';
        $error = true;
    }

    if (empty($_POST['name_media'])) {
        $description_error = 'Veuillez saisir le nom du média !';
        $error = true;
    }

    if (!$error) {
        // Modification du media
        if (!empty($_POST['id_media'])) {
            $success = execute("UPDATE media SET title_media = :title_media, name_media = :name_media, id_page = :id_page, id_media_type= :id_media_type WHERE id_media=:id_media", array(
                ':title_media' => $_POST['title_media'],
                ':name_media' => $_POST['name_media'],
                ':id_page' => $_POST['id_page'],
                ':id_media_type' => $_POST['id_media_type'],
                'id_media' => $_POST['id_media']
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'Le média a été modifé';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./media.php');
            exit();
        } else {
            // Ajouter un contenu
            $success = execute("INSERT INTO media (title_media, name_media, id_page, id_media_type ) VALUES (:title_media, :name_media, :id_page, :id_media_type)", array(
                ':title_media' => $_POST['title_media'],
                ':name_media' => $_POST['name_media'],
                ':id_page' => $_POST['id_page'],
                ':id_media_type' => $_POST['id_media_type'],
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'Nouveau contenu ajouté';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./media.php');
            exit();
        }
    }
}

// recupère la liste des type de médias
$medias = execute("SELECT * FROM media")->fetchAll(PDO::FETCH_ASSOC);

// récupère les pages
$pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);

// récupère les contenus
$contenus = execute("SELECT * FROM content")->fetchAll(PDO::FETCH_ASSOC);

// recupère la liste des type de médias
$listMediaType = execute("SELECT * FROM media_type")->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_GET)) {
    // Recupère un contenu pour la gestion de l'édition
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $mediaById = execute("SELECT * FROM media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression d'un contenu
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        execute("DELETE FROM media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
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

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';

?>

<div class="container">
    <h1 class="text-center mb-5">Gestion des médias</h1>

    <!-- Formulaire pour ajouter du contenu texte -->
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-lg-4 p-3">
            <div class="bg-light shadow rounded p-3">
                <div class="d-flex mb-3">
                    <?php if (isset($contentById) && !empty($contentById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h4>Editer un média</h4>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h4>Nouveau média</h4>
                    <?php } ?>
                </div>

                <form action="" method="post">
                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="title_content" class="form-label">Titre</label>
                        <input type="text" name="title_media" class="form-control" id="title_media" value="<?= $mediaById['title_media'] ?? '' ?>">
                        <small class="text-danger"><?= $title_error  ?? ""; ?></small>
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="name_media" class="form-label">Nom</label>
                        <textarea name="name_media" class="form-control" id="name_media" rows="3"><?= $mediaById['name_media'] ?? '' ?></textarea>
                        <small class="text-danger"><?= $name_error  ?? ""; ?></small>
                        <input name="id_media" value="<?= $mediaById['id_media'] ?? '' ?>" type="hidden">
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="id_page">Selection la page</label>
                        <select class="form-select" aria-label="Default select example" name="id_page" id="id_page">
                       
                            <?php
                            foreach ($pages as $key => $page) {  ?>
                                <option value="<?= $page['id_page'] ?>" <?php if(isset($mediaById) && $mediaById['id_page'] == $page['id_page']){ echo ' selected';} ?> > <?= $page['title_page'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="id_media_type">Selection du type de média</label>
                        <select class="form-select" aria-label="Default select example" name="id_media_type" id="id_media_type">
                            <!-- <option selected></option> -->
                            <?php
                            foreach ($listMediaType as $key => $mediaType) { ?>
                                <option value="<?= $mediaType['id_media_type'] ?>" <?php if(isset($mediaById) && $mediaById['id_media_type'] == $mediaType['id_media_type']){ echo ' selected';} ?> ><?= $mediaType['title_media_type'] ?></option>
                                <!-- <option value="<?= $mediaType['id_media_type'] ?>"  ><?= $mediaType['title_media_type'] ?></option> -->
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="d-flex">
                        <?php if (isset($mediaById) && !empty($mediaById)) { ?>
                            <button type="submit" class="btn btn-outline-success me-2">Editer</button>
                            <a class="btn btn-outline-secondary" href="<?= BASE_PATH . 'back/media.php' ?>">
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
                            <th scope="col">Nom</th>
                            <th scope="col">Page ou afficher le média</th>
                            <th scope="col">Type de média</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($medias as $key => $media) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $media['title_media'] ?></td>
                                <td><?= $media['name_media'] ?></td>
                                <td><?= getProperty($pages, 'title_page', 'id_page', $media['id_page'] ) ?></td>
                                <td><?= getProperty($listMediaType,'title_media_type', 'id_media_type', $media['id_media_type']  ) ?></td>
                                <td class="d-flex">
                                    <a href="<?= BASE_PATH . 'back/media.php?a=edit&i=' . $media['id_media']; ?>" class="btn btn-outline-success me-2">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="<?= BASE_PATH . 'back/media.php?a=del&i=' . $media['id_media']; ?>" class="btn btn-outline-danger">
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

<?php require_once '../inc/backfooter.inc.php'; ?>>