<?php
require_once '../config/function.php';


if (!empty($_POST)) {
    $error = false;

    // Vérifie si un fichier a été téléchargé avec succès
    if (isset($_FILES['title_media'])) {
        if (empty($_FILES['title_media']['name'])) {
            $picture_error = 'Veuillez choisir un fichier !';
            $error = true;
        }
    }

    if (isset($_POST['title_media'])) {
        if (!empty($_POST['title_media'])) {
            $title_error = 'Veuillez saisir le titre du média !';
            $error = true;
        }
    }

    // nom du média dans team sera le pseudo pour les liens et l'avatar
    if (empty($_POST['name_media'])) {
        $name_error = 'Veuillez saisir le nom du média !';
        $error = true;
    }



    if (!$error) {
        // MODIFICATION DU MEDIA
        if (!empty($_POST['id_media'])) {
            $success = execute("UPDATE media SET title_media = :title_media, name_media = :name_media, id_media_type= :id_media_type WHERE id_media=:id_media", array(
                ':title_media' => $_POST['title_media'],
                ':name_media' => $_POST['name_media'],
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
            // UPLOAD DU FICHIER
            if (!empty($_FILES['title_media']['name'])) {

                $fichier = $_FILES['title_media'];
                // Accédez aux informations du fichier
                $nom = $fichier['name'];
                $type = $fichier['type'];
                $taille = $fichier['size'];
                $chemin_temporaire = $fichier['tmp_name'];

                $picture_error ="";

                $formats = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp', 'video/mpeg', 'video/mp4', 'video/webm', 'video/quicktime', 'audio/mpeg', 'audio/ogg', 'audio/aac'];
                if (!in_array($type, $formats)) {
                    $picture_error .= "Les formats autorisés sont: 'image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp'<br>";
                    $error = true;
                }

                if ($taille > 5000000) {
                    $picture_error .= "Taille maximale autorisée de 5M";
                    $error = true;
                }

                $titleMediaType = execute("SELECT title_media_type FROM media_type where id_media_type = :id_media_type",[':id_media_type' =>$_POST['id_media_type']])->fetch(PDO::FETCH_ASSOC);
               
                // Vérifie si le dossier existe on créer un dossier
                $chemin_dossier = '../assets/upload/' . $titleMediaType['title_media_type']; 
                if (!file_exists($chemin_dossier)){ 
                    mkdir ($chemin_dossier, 0777, true);
                }
                // Déplacez le fichier temporaire vers un emplacement permanent
                $destination = $chemin_dossier . '/' . uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . $nom;
                move_uploaded_file($chemin_temporaire, $destination);
            }

            // AJOUT DU MEDIA
            $success = execute("INSERT INTO media (title_media, name_media, id_media_type ) VALUES (:title_media, :name_media, :id_media_type)", array(
                ':title_media' => isset($_FILES['title_media']) ? $_FILES['title_media']['name'] : $_POST['title_media'],
                ':name_media' => $_POST['name_media'],
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

if (!empty($_GET)) {
    // Recupère le media pour l'éditer
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $mediaById = execute("SELECT * FROM media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // Suppression d'un contenu
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $success = execute("DELETE FROM media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ));

        if ($success) {
            $_SESSION['messages']['success'][] = 'Contenu supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./media.php');
        exit();
    }
}

// recupère la liste des types de médias des pages et type de médias avec une requete de jointure 
$medias = execute("SELECT * FROM media m  LEFT JOIN media_type mt ON m.id_media_type=mt.id_media_type")->fetchAll(PDO::FETCH_ASSOC);

// récupère les pages
$pages = execute("SELECT * FROM page")->fetchAll(PDO::FETCH_ASSOC);

// récupère les contenus
$contenus = execute("SELECT * FROM content")->fetchAll(PDO::FETCH_ASSOC);

// recupère la liste des type de médias
$listMediaType = execute("SELECT * FROM media_type")->fetchAll(PDO::FETCH_ASSOC);

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';

?>

<!-- HTML -->
<div class="container">
    <h1 class="text-center mb-5">Gestion des médias</h1>

    <!-- Formulaire pour ajouter du contenu texte -->
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-lg-4 p-3">
            <div class="bg-light shadow rounded p-3">
                <div class="d-flex mb-3">
                    <?php if (isset($mediaById) && !empty($mediaById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h4>Editer un média</h4>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h4>Nouveau média</h4>
                    <?php } ?>
                </div>

                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="id_media_type">Selection du type de média</label>
                        <select class="form-select" aria-label="Default select example" name="id_media_type" id="id_media_type" <?php if (isset($mediaById) && !empty($mediaById)) {
                                                                                                                                    echo ' disabled';
                                                                                                                                } ?>>
                            <?php
                            foreach ($listMediaType as $key => $mediaType) { ?>
                                <option value="<?= $mediaType['id_media_type'] ?>" <?php if (isset($mediaById) && $mediaById['id_media_type'] == $mediaType['id_media_type']) {
                                                                                        echo ' selected';
                                                                                    } ?>>
                                    <?= $mediaType['title_media_type'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3" id="detailMedia"></div>

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
                            <th scope="col">Nom</th>
                            <th scope="col">Emplacement du fichier</th>
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
                                <td><?= $media['name_media'] ?></td>
                                <td><?= $media['title_media'] ?></td>
                                <td><?= $media['title_media_type'] ?></td>
                                <td class="d-flex">
                                    <a href="<?= BASE_PATH . 'back/media.php?a=edit&i=' . $media['id_media']; ?>" class="btn btn-outline-success me-2">
                                        <i class="far fa-edit"></i>
                                    </a>

                                    <a href="<?= BASE_PATH . 'back/media.php?a=del&i=' . $media['id_media']; ?>" class="btn btn-outline-danger">
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

<script>
    let loadFile = function() {
        let image = document.getElementById('image');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    document.addEventListener("DOMContentLoaded", () => {
        const selectBoxMediaType = document.querySelector("#id_media_type");
        const detailMedia = document.querySelector('#detailMedia');

        const mediaFile = () => {
            return `
                <div class="mb-3">
                    <label for="picture_profil" class="form-label">Fichier a télécharger</label>
                    <input onchange="loadFile()" name="title_media" type="file" class="form-control" id="title_media">
                    <small class="text-danger"><?= $picture_error ?? ""; ?></small>
                    <div class="text-center">
                        <img id="image" class="img-fluid mt-3" alt="">
                    </div>
                </div>
            
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="name_media" class="form-label">Nom de l'image (Alt)</label>
                    <input  type="text" name="name_media" class="form-control" id="name_media" value="<?= $mediaById['name_media'] ?? '' ?>">
                    <small class="text-danger"><?= $name_error  ?? ""; ?></small>
                    <input name="id_media" value="<?= $mediaById['id_media'] ?? '' ?>" type="hidden">
                </div>
            `;
        }

        const mediaText = () => {
            return `
            <div class="mb-3">
                <small class="text-danger">*</small>
                <label for="name_media" class="form-label">Saisir le pseudo pour la team</label>
                <input  type="text" name="name_media" class="form-control" id="name_media" value="<?= $mediaById['name_media'] ?? '' ?>">
                <small class="text-danger"><?= $name_error  ?? ""; ?></small>
                <input name="id_media" value="<?= $mediaById['id_media'] ?? '' ?>" type="hidden">
            </div>

            <div class="mb-3">
                <small class="text-danger">*</small>
                <label for="title_content" class="form-label">Saisir le lien</label>
                <input type="text" name="title_media" class="form-control" id="title_media" value="<?= $mediaById['title_media'] ?? '' ?>">
                <small class="text-danger"><?= $title_error  ?? ""; ?></small>
            </div>
            `
        }

        const generateHtmlMediaType = () => {
            if (selectBoxMediaType.options[selectBoxMediaType.selectedIndex].text == 'liens') {
                detailMedia.innerHTML = mediaText();

            } else {
                detailMedia.innerHTML = mediaFile();
            }
        }

        generateHtmlMediaType();

        selectBoxMediaType.addEventListener("click", () => {
            generateHtmlMediaType();
        });

    });
</script>

<?php require_once '../inc/backfooter.inc.php'; ?>>