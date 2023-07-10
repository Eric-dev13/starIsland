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


    if (!$error) {
        // MODIFICATION DU MEDIA (si l'utilisateur clique sur modifi)
        if (!empty($_POST['id_team'])) {

            // Ajout du speudo role recuperer le lastId
            $success = execute("UPDATE team SET role_team=:role_team, nickname_team=:nickname_team WHERE id_team=:id_team", array(
                'id_team' => $_POST['id_team'],
                ':role_team' => $_POST['role_team'],
                ':nickname_team' => $_POST['nickname_team']
            ));

            if ($success) {
                $_SESSION['messages']['success'][] = 'Le profil a été modifé.';
            } else {
                $_SESSION['messages']['danger'][] = 'Problème de traitement';
            }

            header('location:./team.php');
            exit();

        } else {

            // AJOUT DANS TEAM 

            // Ajout du speudo role recuperer le lastId
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

                $chemin_dossier = '../assets/upload/avatarsTeam';
                if (!file_exists($chemin_dossier)) {
                    mkdir($chemin_dossier, 0777, true);
                }
                // Déplacez le fichier temporaire vers un emplacement permanent
                $destination = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . $nom;
                move_uploaded_file($chemin_temporaire, $chemin_dossier . '/' .  $destination);


                // AJOUT DANS LA TABLE MEDIA l'avatar
                $lastIdMedia = execute("INSERT INTO media (title_media, name_media, id_media_type, id_page ) VALUES (:title_media, :name_media, :id_media_type, :id_page)", array(
                    ':title_media' => $destination,
                    ':name_media' => $_POST['nickname_team'],
                    ':id_media_type' => $idMediaType['id_media_type'],
                    ':id_page' => 9
                ), true);

                // AJOUT DANS LA TABLE TEAM_MEDIA d'un enregistrement avec pour un avatar $lastIdTeam, $lastIdMedia
                $success = execute("INSERT INTO team_media (id_media, id_team) VALUES (:id_media, :id_team)", array(
                    ':id_media' => $lastIdMedia,
                    ':id_team' => $lastIdTeam
                ));
            }

            // AJOUTER LES LIENS
            if (isset($_POST['links'])) {
                foreach ($_POST['links'] as $key => $link) {
                    // AJOUT DANS MEDIA DES LIENS
                    $lastIdMediaLink = execute("INSERT INTO media (title_media, name_media, id_media_type, id_page ) VALUES (:title_media, :name_media, :id_media_type, :id_page)", array(
                        ':title_media' => $link,
                        ':name_media' => isset($_POST['name_media'][$key]) && !empty($_POST['name_media'][$key]) ? $_POST['name_media'][$key] : $_POST['nickname_team'],
                        ':id_page' => 9,
                        ':id_media_type' => 22
                    ), true);

                    // AJOUT DANS LA TABLE DE LIAISON TEAM_MEDIA un enregistrement avec pour les liens $lastIdTeam, $lastIdMedia
                    $success = execute("INSERT INTO team_media (id_media, id_team) VALUES (:id_media, :id_team)", array(
                        ':id_media' => $lastIdMediaLink,
                        ':id_team' => $lastIdTeam
                    ));
                }
            }
        }
    }
}

if (!empty($_GET)) {
    /* 
    EDITER LE TEAM - Requête Par ID pour récupèrer les données de la team et afficher les données dans les champs du formulaire
    + input de type hidden avec l'ID lors de la soumission l'ID est envoyé au serveur pour faire l'UPDATE.
    */
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $teamById = execute("SELECT * FROM team WHERE id_team=:id_team", array(
            ':id_team' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // SUPPRIME UN ENREGISTREMENT DE TEAM ET CASCADE SUR LES TABLES LIES
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {

        $idMediasFromTeamMedia = execute("SELECT * FROM team_media tm INNER JOIN media m ON tm.id_media=m.id_media INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE id_team=:id_team", array(
            ':id_team' => $_GET['i']
        ))->fetchAll(PDO::FETCH_ASSOC);

        // execute("BEGIN TRANSACTION");

        // Supprimer les enregistrements de la table TEAM_MEDIA
        $mediaTeam = execute("DELETE FROM team_media WHERE id_team=:id_team", array(
            ':id_team' => $_GET['i']
        ));

        // Supprime les liens / avatar dans la table MEDIA
        foreach ($idMediasFromTeamMedia as $key => $idMedia) {
            execute("DELETE FROM media WHERE id_media=:id_media", array(
                ':id_media' => $idMedia['id_media']
            ));
            // Suppression de l'avatar s'il existe
            if ($idMedia['type_media_type'] == 'file') {
                unlink('../assets/upload/' . $idMedia['title_media_type'] . '/' . $idMedia['title_media']);
            }
        }

        // Supprimer le membre de l'équipe dans la table TEAM
        $success = execute("DELETE FROM team WHERE id_team=:id_team", array(
            ':id_team' => $_GET['i']
        ));

        // execute("COMMIT");

        if ($success) {
            $_SESSION['messages']['success'][] = 'Collaborateur supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./team.php');

        exit();
    }

    // Suppression d'un média
    if (isset($_GET['a']) && $_GET['a'] == 'delmedia' && isset($_GET['i'])) {
        // Récupere les infos du média a suprrimer (gestion de la suppression du fichier)
        $mediaForDelete = execute("SELECT * from media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE id_media=:id_media ", array(
            ':id_media' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);

        // suppression dans la table de liaison team_media
        $success = execute("DELETE FROM team_media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ));

        // suppression de l'enregistrement de la table media
        $success = execute("DELETE FROM media WHERE id_media=:id_media", array(
            ':id_media' => $_GET['i']
        ));

        // Suppression de l'avatar s'il existe
        if ($mediaForDelete['type_media_type'] == 'file') {
            unlink('../assets/upload/' . $mediaForDelete['title_media_type'] . '/' . $mediaForDelete['title_media']);
        }

        if ($success) {
            $_SESSION['messages']['success'][] = 'Média supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./team.php');
        exit();
    }
}

// function getRole(string $role) {
//     if (isset($teamById) && $teamById['role_team'] == $role) {
//         return 'selected';
//     }
//     return '';
// }

// OBTENIR LA LISTE DES TEAMS 
$teams = execute("SELECT t.id_team,t.role_team, t.nickname_team FROM team t")->fetchAll(PDO::FETCH_ASSOC);

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion de l'équipe</h1>
    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-6 border mb-3 p-3" style="background-color: #869f7136;">
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex mb-3">
                    <?php if (isset($teamById) && !empty($teamById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h3>Mettre à jour le profil d'un collaborateur</h3>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h3>Ajouter un collaborateur</h3>
                    <?php } ?>
                </div>

                <!-- PSEUDO -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="nickname_team" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="nickname_team" name="nickname_team" placeholder="Pseudo" value="<?= $teamById['nickname_team'] ?? '' ?>">
                </div>

                <!-- ROLE -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="role_team" class="form-label">Role</label>
                    <select class="form-select" aria-label="Default select example" id="role_team" name="role_team" ?>">
                        <option selected disabled>Sélectionner un rôle</option>
                        <option value="Tous" <?php if(isset($teamById) && $teamById['role_team'] == "Tous") echo 'selected'; ?> >Tous</option>
                        <option value="Admins" <?php if(isset($teamById) && $teamById['role_team'] == "Admins") echo 'selected'; ?> >Admins</option>
                        <option value="Staffs/Modos" <?php if(isset($teamById) && $teamById['role_team'] == "Staffs/Modos") echo 'selected'; ?> >Staffs/Modos</option>
                        <option value="Développeurs" <?php if(isset($teamById) && $teamById['role_team'] == "Développeurs") echo 'selected'; ?> >Développeurs</option>
                        <option value="Mappers" <?php if(isset($teamById) && $teamById['role_team'] == "Mappers") echo 'selected'; ?> >Mappers</option>
                        <option value="Helpers" <?php if(isset($teamById) && $teamById['role_team'] == "Helpers") echo 'selected'; ?> >Helpers</option>
                    </select>
                </div>

                <!-- MASQUE LES MEDIAS EN MODE MODIFICATION DE LA TEAM -->
                <?php 
                 if(!isset($teamById) && !empty($teamById)) {
                ?>
                <!-- AVATAR + ALT -->
                <div class="border border-light p-3 mb-3">
                    <h5>Choisir un avatar</h5>
                    <label for="title_media" class="form-label">Fichier a télécharger</label>
                    <input onchange="loadFile()" name="title_media" type="file" class="form-control" id="title_media">
                    <div class="text-center">
                        <img id="image" class="img-fluid mt-3" alt="">
                    </div>
                </div>

                <!-- LIENS VERS RESEAUX SOCIAUX -->
                <div class="border p-3 mb-3">
                    <h5>Créer des liens vers les reseaux sociaux</h5>
                    <div class="text-center mb-3">
                        <a href="#" id="addLink" class="btn btn-outline-dark"><small class="fw-bold fs-6 me-3">NEW</small><i class="fas fa-link text-primary"></i></a>
                    </div>
                    <div id="collectionLink"></div>
                </div>
                <?php } ?>

                <!-- Valeur remontée Input caché pour remonter id_team a modifier sur requête UPDATE -->
                <input  type="hidden" name="id_team" value="<?= $teamById['id_team'] ?? '' ?>">

                <!-- SOUMISSION DU FORMULAIRE -->
                <div class="d-flex flex-column">
                    <?php if (isset($teamById) && !empty($teamById)) { ?>
                        <button type="submit" class="btn btn-lg btn-primary mb-2">Editer</button>
                        <a class="btn btn-secondary" href="<?= BASE_PATH . 'back/team.php' ?>">
                            Annuler
                        </a>
                    <?php } else { ?>
                        <button type="submit" class="btn btn-lg btn-primary">Ajouter</button>
                    <?php } ?>
                </div>
            </form>
        </div>

        <div class="col-12 border p-3" style="background-color: #869f7136;">
            <!-- LISTE TEAM -->
            <div class="d-flex mb-3">
                <i class="fas fa-scroll fa-2x text-success me-2"></i>
                <h4 class="mb-3">L'équipe</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Rôle</th>
                            <th scope="col">Détail (Titre, Nom, Type de média)</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($teams as $key => $team) {
                            $medias = execute("SELECT m.*, mt.*, p.* FROM team_media tm INNER JOIN media m ON tm.id_media=m.id_media INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type JOIN page p ON m.id_page=p.id_page WHERE tm.id_team=:id_team", array(
                                ':id_team' => $team['id_team']
                            ))->fetchAll(PDO::FETCH_ASSOC); ?>
                            <tr>
                                <td><?= $team['nickname_team'] ?></th>
                                <td><?= $team['role_team'] ?></th>
                                <td>
                                    <?php foreach ($medias as $media) : ?>
                                        <div class="d-flex align-items-center border mb-1">
                                            <div class="mx-2">
                                                <a href="<?= BASE_PATH . 'back/media.php?a=edit&i=' . $media['id_media']; ?>" class="btn btn-outline-success me-2">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="<?= BASE_PATH . 'back/team.php?a=delmedia&i=' . $media['id_media']; ?>" class="btn btn-outline-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </div>
                                            <div style="min-width: 400px;">
                                                <div>
                                                    <?php if ($media['type_media_type'] != 'text') { ?>
                                                        <img src="<?= BASE_PATH . 'assets/upload/avatarsTeam/' . $media['title_media']  ?>" class="rounded-circle p-1 me-2" alt="<?= $media['title_media'] ?>" width="70">
                                                        <small>
                                                            <?= $media['title_media'] ?>
                                                        </small>
                                                    <?php } else { ?>
                                                        <small>
                                                            <span class='fw-bold'>Titre : </span>
                                                            <?= $media['title_media'] ?>
                                                        </small>
                                                    <?php } ?>
                                                </div>
                                                <div>
                                                    <small>
                                                        <span class="fw-bold">Type de média : </span>
                                                        <?= $media['title_media_type'] ?>
                                                    </small>
                                                </div>
                                                <div>
                                                    <small>
                                                        <span class="fw-bold">Nom : </span>
                                                        <?= $media['name_media'] ?>
                                                    </small>
                                                </div>
                                                <div>
                                                    <small>
                                                        <span class="fw-bold">Page : </span>
                                                        <?= $media['title_page'] ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </td>

                                <td>
                                    <div class="d-flex">
                                        <a href="<?= BASE_PATH . 'back/team.php?a=edit&i=' . $team['id_team']; ?>" class="btn btn-outline-success me-2">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_PATH . 'back/team.php?a=del&i=' . $team['id_team']; ?>" class="btn btn-outline-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    let loadFile = function() {
        let image = document.getElementById('image');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    let compteur = 0;

    document.addEventListener('DOMContentLoaded', () => {
        const loadFile = () => {
            let image = document.getElementById('image');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        document.querySelector("#addLink").addEventListener('click', () => {
            let newElement = document.createElement("div");
            // Ajoute une classe à l'élément
            newElement.classList.add("border", "border-secondary", "mb-3", "p-2");
            newElement.id = `link-${compteur}`;
            newElement.innerHTML = `
            <div class="mb-3">
                <small class="text-danger">*</small>
                <label for="name_media" class="form-label">Saisir un nom pour le lien (ex: Discord)</label>
                <input  type="text" name="name_media[]" class="form-control" id="name_media">
            </div>
            <div class="mb-3">
            <small class="text-danger">*</small>
            <label for="title_content" class="form-label">Saisir le lien</label>
            <input type="text" class="form-control me-3" name="links[]">
            </div>
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