<?php
require_once '../config/function.php';

if (!empty($_POST)) {
    $error = false;

    // pseudo
    if (empty($_POST['nickname_team'])) {
        $name_error = 'Veuillez saisir le pseudo de cet équipier !';
        $error = true;
    }

    // role
    if (empty($_POST['role_team'])) {
        $name_error = 'Veuillez saisir le rôle de cet équipier !';
        $error = true;
    }

    // avatar
    // if (empty($_FILES['title_media']['name'])) {
    //     $picture_error = 'Veuillez choisir un fichier !';
    //     $error = true;
    // }

    // NOM POUR L'ATTR ALT 
    // if (empty($_POST['name_media'])) {
    //     $name_error = 'Veuillez saisir le nom du média !';
    //     $error = true;
    // }

    // // liens
    // if (empty($_POST['link'])) {
    //     $name_error = 'Veuillez saisir le pseudo de cet équipier !';
    //     $error = true;
    // }

    if (!$error) {

        // AJOUT DANS TEAM du speudo et role recuperer le lastId
        $lastIdTeam = execute("INSERT INTO team (role_team, nickname_team ) VALUES (:role_team, :nickname_team)", array(
            ':role_team' => $_POST['role_team'],
            ':nickname_team' => $_POST['nickname_team']
        ), true);

        // MEDIA - UPLOAD DU FICHIER - TYPE FILE
        if (!empty($_FILES['title_media']['name'])) {
            // vérifie que le name a été saisi
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

            $idMediaType = execute("SELECT id_media_type FROM media_type where title_media_type = :title_media_type", ['title_media_type' => 'avatarsTeam'])->fetch(PDO::FETCH_ASSOC);

            // recupère la liste des type de médias

            $chemin_dossier = '../assets/upload/avatarsTeam';
            if (!file_exists($chemin_dossier)) {
                mkdir($chemin_dossier, 0777, true);
            }
            // Déplacez le fichier temporaire vers un emplacement permanent
            $destination = $chemin_dossier . '/' . uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . $nom;
            move_uploaded_file($chemin_temporaire, $destination);

            // AJOUT DANS LA TABLE MEDIA
            $lastIdMedia = execute("INSERT INTO media (title_media, name_media, id_media_type ) VALUES (:title_media, :name_media, :id_media_type)", array(
                ':title_media' => $_FILES['title_media']['name'],
                ':name_media' => $_POST['nickname_team'],
                ':id_media_type' => $idMediaType['id_media_type'],
            ), true);

            // AJOUT DANS LA TABLE TEAM_MEDIA d'un enregistrement avec pour un avatar $lastIdTeam, $lastIdMedia
            $success = execute("INSERT INTO team_media (id_media, id_team) VALUES (:id_media, :id_team)", array(
                ':id_media' => $lastIdMedia,
                ':id_team' => $lastIdTeam
            ));
        }

        // AJOUTER LES LIENS
        foreach ($_POST['links'] as $key => $link) {
            // AJOUT DANS MEDIA DES LIENS
            $lastIdMediaLink = execute("INSERT INTO media (title_media, name_media, id_media_type ) VALUES (:title_media, :name_media, :id_media_type)", array(
                ':title_media' => $link,
                ':name_media' => $_POST['nickname_team'],
                ':id_media_type' => "22",
            ), true);

            // AJOUT DANS LA TABLE  DE LIAISON TEAM_MEDIA d'un enregistrement avec pour les liens $lastIdTeam, $lastIdMedia
            $success = execute("INSERT INTO team_media (id_media, id_team) VALUES (:id_media, :id_team)", array(
                ':id_media' => $lastIdMediaLink,
                ':id_team' => $lastIdTeam
            ));
        }

        // if ($success) {
        //     $_SESSION['messages']['success'][] = $_POST['nickname_team'] . ' a été ajouté dans la team.';
        // } else {
        //     $_SESSION['messages']['danger'][] = 'Problème de traitement';
        // }

        // header('location:./team.php');
        // exit();
    }
}


// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion de l'équipe</h1>
    <div class="row">
        <div class="col-12 col-lg-6">
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex mb-3">
                    <?php if (isset($teamById) && !empty($teamById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h3>Modifier un équipier</h3>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h3>Ajouter un équipier</h3>
                    <?php } ?>
                </div>

                <!-- PSEUDO -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="nickname_team" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="nickname_team" name="nickname_team" placeholder="Pseudo" value="<?= $teamById['nickname_team
                    '] ?? '' ?>">
                </div>

                <!-- ROLE -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="role_team" class="form-label">Role</label>
                    <select class="form-select" aria-label="Default select example" id="role_team" name="role_team">
                        <option selected>Sélectionner un rôle</option>
                        <option value="Tous">Tous</option>
                        <option value="Admins">Admins</option>
                        <option value="Staffs/Modos">Staffs/Modos</option>
                        <option value="Développeurs">Développeurs</option>
                        <option value="Mappers">Mappers</option>
                        <option value="Helpers">Helpers</option>
                    </select>
                </div>

                <!-- AVATAR + ALT -->
                <div class="border p-3 mb-3">
                    <div class="mb-3">
                        <h4>Choisir un avatar</h4>
                        <label for="title_media" class="form-label">Fichier a télécharger</label>
                        <input onchange="loadFile()" name="title_media" type="file" class="form-control" id="title_media">
                        <!-- <small class="text-danger"><?= $picture_error ?? ""; ?></small> -->
                        <div class="text-center">
                            <img id="image" class="img-fluid mt-3" alt="">
                        </div>
                    </div>
                </div>

                <!-- LIENS VERS RESEAUX SOCIAUX -->
                <div class="border p-3 mb-3">
                    <h4>Créer des liens vers les reseaux sociaux</h4>
                    <a href="#" id="addLink" class="btn btn-outline-dark mb-3"><small class="fw-bold fs-6 me-3">NEW</small><i class="fas fa-link text-primary"></i></a>
                    <div id="collectionLink"></div>
                </div>

                <!-- SOUMISSION DU FORMULAIRE -->
                <div class="d-flex">
                    <?php if (isset($teamById) && !empty($teamById)) { ?>
                        <button type="submit" class="btn btn-lg btn-outline-success me-2">Editer</button>
                        <a class="btn btn-outline-secondary" href="<?= BASE_PATH . 'back/team.php' ?>">
                            Annuler
                        </a>
                    <?php } else { ?>
                        <button type="submit" class="btn btn-lg btn-outline-primary">Ajouter</button>
                    <?php } ?>
                </div>

            </form>
        </div>

        <div class="col-12 col-lg-6">
                        
        </div>
    </div>
</div>

<script>
    let compteur = 0;

    document.addEventListener('DOMContentLoaded', () => {
        const loadFile = () => {
            let image = document.getElementById('image');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        document.querySelector("#addLink").addEventListener('click', () => {
            let newElement = document.createElement("div");
            // Ajoute une classe à l'élément
            newElement.classList.add("d-flex", "mb-3");
            newElement.id = `link-${compteur}`;
            newElement.innerHTML = `
            <input type="text" class="form-control me-3" name="links[]">
            <a href="#" class="btn btn-danger" id="btnLink-${compteur}"><i class="fas fa-trash-alt"></i></a>
        `

            // Ajoute le nouvel élément au parent existant
            document.querySelector('#collectionLink').appendChild(newElement);

            // AVEC InnerHTML impossible de conserver l'event ajouté le tour d'avant comme si tout était effacer puis récrit ?
            // Suppression de l'élément
            document.querySelector('#btnLink-' + compteur).addEventListener('click', () => {
                newElement.remove();
            });
            compteur++;
        });
    });
</script>

<?php require_once '../inc/backfooter.inc.php'; ?>