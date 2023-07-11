<?php
require_once '../config/function.php';


if (!empty($_POST)) {
    $error = false;

    // Vérifie si un fichier a été téléchargé
    if (isset($_FILES['title_media'])) {
        if (empty($_FILES['title_media']['name']) && empty($_POST['id_media'])) {
            $picture_error = 'Veuillez choisir un fichier !';
            $error = true;
        }
    }

    // Titre du media
    if (isset($_POST['title_media'])) {
        if (empty($_POST['title_media'])) {
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

            $getMediaForUpdate = execute("SELECT * FROM media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE id_media=:id_media", array(
                ':id_media' => $_POST['id_media']
            ))->fetch(PDO::FETCH_ASSOC);

            // Recupere le titre du média type
            $formTitleMediaType = execute("SELECT title_media_type FROM media_type where id_media_type = :id_media_type", [
                ':id_media_type' => $_POST['id_media_type']
            ])->fetch(PDO::FETCH_ASSOC);

            // Upload du fichier
            if (!empty($_FILES['title_media']['name'])) {
                $fichier = $_FILES['title_media'];
                // Accédez aux informations du fichier
                $nom = $fichier['name'];
                $type = $fichier['type'];
                $taille = $fichier['size'];
                $chemin_temporaire = $fichier['tmp_name'];

                $picture_error = "";

                $formats = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp', 'video/mpeg', 'video/mp4', 'video/webm', 'video/quicktime', 'audio/mpeg', 'audio/ogg', 'audio/aac'];
                if (!in_array($type, $formats)) {
                    $picture_error .= "Les formats autorisés sont: 'image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp'<br>";
                    $error = true;
                }

                if ($taille > 5000000) {
                    $picture_error .= "Taille maximale autorisée de 5M";
                    $error = true;
                }

                // Vérifie si le dossier existe on créer un dossier
                $chemin_dossier = '../assets/upload/' . $formTitleMediaType['title_media_type'];
                if (!file_exists($chemin_dossier)) {
                    mkdir($chemin_dossier, 0777, true);
                }
                // Déplacez le fichier temporaire vers un emplacement permanent
                $destination = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . $nom;
                move_uploaded_file($chemin_temporaire, $chemin_dossier . '/' .  $destination);

                // Supprime l'ancien fichier
                unlink('../assets/upload/' . $getMediaForUpdate['title_media_type'] . '/' . $getMediaForUpdate['title_media']);
            }

            // si on change le type de média file vers text on doit supprimer l'image
            $formTypeMedia = execute("SELECT type_media_type FROM media_type where id_media_type = :id_media_type", [
                ':id_media_type' => $_POST['id_media_type']
            ])->fetch(PDO::FETCH_ASSOC);

            if ($getMediaForUpdate['type_media_type'] == 'file' &&  $formTypeMedia['type_media_type'] == 'text') {
                // Supprime l'ancien fichier
                unlink('../assets/upload/' . $getMediaForUpdate['title_media_type'] . '/' . $getMediaForUpdate['title_media']);
            }


            // title_media path pour le fichier, titre pour alt 3 possibilité : new path, liens, old path
            $newTitleMedia = null;
            // si un fichier a été telecharger
            if (!empty($_FILES['title_media']['name'])) {
                // ajout le path
                $newTitleMedia = $destination;
            } else {
                // Sinon on verifie si c'est un lien
                if (isset($_POST['title_media'])) {
                    $newTitleMedia = $_POST['title_media'];
                } else {
                    // on conserve l'ancien path du fichier
                    $newTitleMedia = $getMediaForUpdate['title_media'];

                    // on deplace le fichier dans le bon dossier si changement du type de média
                    if ($_POST['id_media_type'] !=  $getMediaForUpdate['id_media_type']) {
                        $dossierSource = '../assets/upload/' . $getMediaForUpdate['title_media_type'] . '/' . $getMediaForUpdate['title_media'];
                        $dossierDestination =  '../assets/upload/' . $formTitleMediaType['title_media_type'] . '/' . $getMediaForUpdate['title_media'];
                        copy($dossierSource, $dossierDestination);
                        unlink('../assets/upload/' . $getMediaForUpdate['title_media_type'] . '/' . $getMediaForUpdate['title_media']);
                    }
                }
            }

            // Update Table
            $success = execute("UPDATE media SET title_media = :title_media, name_media = :name_media, id_page = :id_page, id_media_type= :id_media_type WHERE id_media=:id_media", array(
                ':title_media' => $newTitleMedia,
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
            //AJOUTER UN MEDIA
            // Upload du fichier
            if (!empty($_FILES['title_media']['name'])) {

                $fichier = $_FILES['title_media'];
                // Accédez aux informations du fichier
                $nom = $fichier['name'];
                $type = $fichier['type'];
                $taille = $fichier['size'];
                $chemin_temporaire = $fichier['tmp_name'];

                $picture_error = "";

                $formats = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp', 'video/mpeg', 'video/mp4', 'video/webm', 'video/quicktime', 'audio/mpeg', 'audio/ogg', 'audio/aac'];
                if (!in_array($type, $formats)) {
                    $picture_error .= "Les formats autorisés sont: 'image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp'<br>";
                    $error = true;
                }

                if ($taille > 5000000) {
                    $picture_error .= "Taille maximale autorisée de 5M";
                    $error = true;
                }

                $titleMediaType = execute("SELECT title_media_type FROM media_type where id_media_type = :id_media_type", [
                    ':id_media_type' => $_POST['id_media_type']
                ])->fetch(PDO::FETCH_ASSOC);

                // Vérifie si le dossier existe on créer un dossier
                $chemin_dossier = '../assets/upload/' . $titleMediaType['title_media_type'];
                if (!file_exists($chemin_dossier)) {
                    mkdir($chemin_dossier, 0777, true);
                }
                // Déplacez le fichier temporaire vers un emplacement permanent
                $destination = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . $nom;
                move_uploaded_file($chemin_temporaire, $chemin_dossier . '/' .  $destination);
            }

            // AJOUT DU MEDIA
            $success = execute("INSERT INTO media (title_media, name_media, id_page, id_media_type ) VALUES (:title_media, :name_media, :id_page, :id_media_type)", array(
                ':title_media' => isset($_FILES['title_media']) ? $destination : $_POST['title_media'],
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

if (!empty($_GET)) {
    // EDITER LE MEDIA - Requête pour récupèrer les données du media et l'afficher dans le formulaire
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $mediaById = execute("SELECT * FROM media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // SUPPRIME UN ENREGISTREMENT DE MEDIA
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        $getMedia = execute("SELECT m.title_media, mt.title_media_type, mt.type_media_type FROM media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);

        $success = execute("DELETE FROM media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ));

        // Supprime le fichier
        if ($getMedia['type_media_type'] == 'file') {
            unlink('../assets/upload/' . $getMedia['title_media_type'] . '/' . $getMedia['title_media']);
        }


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
$medias = execute("SELECT * FROM media m LEFT JOIN media_type mt ON m.id_media_type=mt.id_media_type LEFT JOIN page p ON m.id_page=p.id_page")->fetchAll(PDO::FETCH_ASSOC);

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
        <div class="col-12 col-md-6 p-3">
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
                        <label for="id_page">Selection la page</label>
                        <select class="form-select" aria-label="Default select example" name="id_page" id="id_page">
                            <?php
                            foreach ($pages as $key => $page) {  ?>
                                <option value="<?= $page['id_page'] ?>" <?php if (isset($mediaById) && $mediaById['id_page'] == $page['id_page']) {
                                                                            echo ' selected';
                                                                        } ?>> <?= $page['title_page'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <small class="text-danger">*</small>
                        <label for="id_media_type">Selection du type de média</label>
                        <select class="form-select" aria-label="Default select example" name="id_media_type" id="id_media_type">
                            <?php
                            foreach ($listMediaType as $key => $mediaType) { ?>
                                <option data-type="<?= $mediaType['type_media_type'] ?>" value="<?= $mediaType['id_media_type'] ?>" <?php if (isset($mediaById) && $mediaById['id_media_type'] == $mediaType['id_media_type']) {
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
                            <th scope="col">Nom</th>
                            <th scope="col">Page ou afficher le média</th>
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
                                <td><?= $media['title_page'] ?></td>
                                <td>
                                    <?php if ($media['type_media_type'] == 'file') : ?>
                                        <small><?= $media['title_media'] ?></small><br>
                                        <img src="<?= BASE_PATH . 'assets/upload/' . $media['title_media_type'] . '/' . $media['title_media'] ?>" alt="<?= $media['title_media_type'] ?>" width="100">
                                    <?php else : ?>
                                        <?= $media['title_media'] ?>
                                    <?php endif ?>
                                </td>
                                <td><?= $media['title_media_type'] ?></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="<?= BASE_PATH . 'back/media.php?a=edit&i=' . $media['id_media']; ?>" class="btn btn-outline-success me-2">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="<?= BASE_PATH . 'back/media.php?a=del&i=' . $media['id_media']; ?>" class="btn btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
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
                        <img src="<?= '../assets/upload/' . $mediaById['title_media_type'] . '/' . $mediaById['title_media'] ?>" id="image" class="img-fluid p-3 mt-3" alt="Image" >
                    </div>
                </div>
            
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="name_media" class="form-label">Nom de l'image (Alt)</label>
                    <input  type="text" name="name_media" class="form-control" id="name_media" value="<?= $mediaById['name_media'] ?? '' ?>">
                    <small class="text-danger"><?= $name_error ?? ""; ?></small>
                    <input name="id_media" value="<?= $mediaById['id_media'] ?? '' ?>" type="hidden">
                </div>
            `;
        }

        const mediaText = () => {
            return `
            <div class="mb-3">
                <small class="text-danger">*</small>
                <label for="name_media" class="form-label">Saisir un nom pour le lien (ex: Discord)</label>
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
            let selectedOption = selectBoxMediaType.options[selectBoxMediaType.selectedIndex];
            let typeMedia = selectedOption.dataset.type;
            if (typeMedia == 'text') {
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

<?php require_once '../inc/backfooter.inc.php'; ?>