<?php
require_once '../config/function.php';

// ajouter un type de média
if (!empty($_POST)) {
    $error = false;

    if (empty($_POST['title_media_type'])) {
        $title_media_error = 'Veuillez saisir un nom pour ce média !';
        $error = true;
    }

    if (!$error) {
        // Modification un type de média
        if (!empty($_POST['id_media_type'])) {
            $success = execute("UPDATE media_type SET title_media_type = :title_media_type WHERE id_media_type=:id", array(
                ':title_media_type' => $_POST['title_media_type'],
                ':id' => $_POST['id_media_type']
            ));

            if($success) {
                $_SESSION['messages']['success'][] = 'Le type de média a été modifé.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./mediaType.php');
            exit();

        } else {
            // Ajouter un type de média
            $success = execute("INSERT INTO media_type (title_media_type) VALUES (:title_media_type)", array(
                ':title_media_type' => $_POST['title_media_type']));

            if($success) {
                // Création du dossier s'il n'exite pas avec le nom du type de média.
                $chemin_dossier = '../assets/upload/' . $_POST['title_media_type']; 
                if (!file_exists($chemin_dossier)){ 
                    mkdir ($chemin_dossier, 0777, true);
                }
                $_SESSION['messages']['success'][] = 'Nouveau type de média ajouté.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./mediaType.php');
            exit();
        }
    }
}

// recupère la liste des type de médias
$listMediaType = execute("SELECT * FROM media_type")->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_GET)) {
    // Recupère un type de média pour la gestion de l'édition
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $mediaById = execute("SELECT * FROM media_type WHERE id_media_type=:id", array(
            ':id' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression un type de média
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $success = execute("DELETE FROM media_type WHERE id_media_type=:id", array(
            ':id' => $_GET['i']
        ));

        if($success) {
            $_SESSION['messages']['success'][] = 'Type supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./mediaType.php');
        exit();
    }
}

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>



<section class="container mt-5">
    <h1 class="text-center mb-5">Gestion des types de médias</h1>

    <!-- Formulaire pour ajouter un type de média -->
    <div class="row justify-content-center">

        <div class="col-12 col-lg-6 p-3">
            <div class="bg-light shadow p-3">
                <div class="d-flex mb-3">
                    <?php if (isset($mediaById) && !empty($mediaById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h4>Editer le type</h4>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h4>Nouveau type</h4>
                    <?php } ?>
                </div>

                <form method="post">
                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="mediaType" class="form-label">Nom du type de média</label>
                        <input type="text" name="title_media_type" class="form-control" id="title_media_type" placeholder="Nom" value="<?= $mediaById['title_media_type'] ?? '' ?>">
                        <small class="text-danger"><?= $title_media_error  ?? ""; ?></small>
                        <input name="id_media_type" value="<?= $mediaById['id_media_type'] ?? '' ?>" type="hidden">
                    </div>

                    <div class="d-flex">
                        <?php if (isset($mediaById) && !empty($mediaById)) { ?>
                            <button type="submit" class="btn btn-outline-success me-2">Editer</button>
                            <a class="btn btn-outline-secondary" href="<?= BASE_PATH . 'back/mediaType.php' ?>">
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
            <div class="bg-light shadow p-3">
                <div class="d-flex mb-3">
                    <i class="fas fa-scroll fa-2x text-success me-2"></i>
                    <h4 class="mb-3">Types de médias</h4>
                </div>

                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom du média</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($listMediaType as $key => $value) { ?>
                            <tr>
                                <th scope="row"><?= $key ?></th>
                                <td><?= $value['title_media_type'] ?></td>
                                <td class="d-flex">
                                    <a href="<?= BASE_PATH . 'back/mediatype.php?a=edit&i=' . $value['id_media_type']; ?>" class="btn btn-outline-success me-2">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="<?= BASE_PATH . 'back/mediatype.php?a=del&i=' . $value['id_media_type']; ?>" class="btn btn-outline-danger">
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

</section>

<?php require_once '../inc/backfooter.inc.php'; ?>