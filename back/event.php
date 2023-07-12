<?php
require_once '../config/function.php';

if (!empty($_POST)) {
    $error = false;

    //  date de début
    if (empty($_POST['start_date_event'])) {
        $dateDebut_error = 'Veuillez saisir la date de début !';
        $error = true;
    }

    // date de fin
    if (empty($_POST['end_date_event'])) {
        $dateFin_error = 'Veuillez saisir la date de fin !';
        $error = true;
    }

    // Avatars
    if (empty($_FILES['title_media']['name'])) {
        $avatar_error = 'Veuillez sélectionner un avatar !';
        $error = true;
    } else {
        // vérifie que le name a été saisi
        $fichier = $_FILES['title_media'];
        // Accédez aux informations du fichier
        $nom = $fichier['name'];
        $type = $fichier['type'];
        $taille = $fichier['size'];
        $chemin_temporaire = $fichier['tmp_name'];

        $avatar_error = "";

        $formats = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp', 'video/mpeg', 'video/mp4', 'video/webm', 'video/quicktime', 'audio/mpeg', 'audio/ogg', 'audio/aac'];
        if (!in_array($type, $formats)) {
            $avatar_error .= "Les formats autorisés sont: 'image/png', 'image/jpg', 'image/jpeg', 'image/gif', 'image/webp'<br>";
            $error = true;
        }

        if ($taille > 5000000) {
            $avatar_error .= "Taille maximale autorisée de 5M";
            $error = true;
        }
    }

    // Titre de l'évenement
    if (empty($_POST['title_content'])) {
        $commentaires_error = 'Veuillez saisir un commentaire !';
        $error = true;
    }

    // Commentaires
    if (empty($_POST['description_content'])) {
        $commentaires_error = 'Veuillez saisir un commentaire !';
        $error = true;
    }

    if (!$error) {
        // AJOUT de la date de debut et de fin dans EVENT.
        // $today = $_POST['end_date_event'];
        // $previousMonth = date("Y-m-d H:i:s", strtotime("-1 month", strtotime($today)));
        // echo $previousMonth;

        $lastIdEvent = execute("INSERT INTO event (start_date_event, end_date_event) VALUES (:start_date_event, :end_date_event)", array(
            ':start_date_event' => $_POST['start_date_event'],
            ':end_date_event' => $_POST['end_date_event']
        ), true);

        // Récupération de l'id de la page
        $getPageEvent = execute("SELECT id_page FROM page WHERE title_page=:title_page", [
            'title_page' => 'evenement'
        ])->fetch(PDO::FETCH_ASSOC);

        // Ajout titre, description, id page dans CONTENT.
        $lastIdContent = execute("INSERT INTO content (title_content , description_content, id_page ) VALUES (:title_content, :description_content, :id_page)", array(
            ':title_content' => $_POST['title_content'],
            ':description_content' => $_POST['description_content'],
            ':id_page' => $getPageEvent['id_page']
        ), true);

        // Ajout d'un enregistrement dans event_content
        execute("INSERT INTO event_content (id_event, id_content) VALUES (:id_event, :id_content)", array(
            ':id_event' => $lastIdEvent,
            ':id_content' => $lastIdContent,
        ));

        // AJOUT DU MEDIA - UPLOAD DU FICHIER - TYPE FILE
        $idMediaType = execute("SELECT id_media_type FROM media_type where title_media_type = :title_media_type", [
            'title_media_type' => 'avatarEvent'
        ])->fetch(PDO::FETCH_ASSOC);

        $chemin_dossier = '../assets/upload/avatarEvent';
        if (!file_exists($chemin_dossier)) {
            mkdir($chemin_dossier, 0777, true);
        }

        // Déplacez le fichier temporaire vers un emplacement permanent
        $destination = uniqid() . date_format(new DateTime(), 'd_m_Y_H_i_s') . $nom;
        move_uploaded_file($chemin_temporaire, $chemin_dossier . '/' .  $destination);

        // AJOUT DANS LA TABLE MEDIA
        $lastIdMedia = execute("INSERT INTO media (title_media, name_media, id_media_type, id_page ) VALUES (:title_media, :name_media, :id_media_type, :id_page)", array(
            ':title_media' => $destination,
            ':name_media' => $_POST['title_content'],
            ':id_media_type' => $idMediaType['id_media_type'],
            ':id_page' => $getPageEvent['id_page']
        ), true);

        // AJOUT DANS LA TABLE TEAM_MEDIA d'un enregistrement avec pour l'image
        $success = execute("INSERT INTO event_media (id_media, id_event) VALUES (:id_media, :id_event )", array(
            ':id_media' => $lastIdMedia,
            ':id_event' => $lastIdEvent
        ));
    }
}

if (!empty($_GET)) {
    if (isset($_GET['a']) && $_GET['a'] == 'activate' && isset($_GET['i'])) {
        execute("UPDATE event SET activate=:activate", array(
            ':activate' => 0
        ));
        $success = execute("UPDATE event SET activate=:activate WHERE id_event =:id_event", array(
            ':id_event' => $_GET['i'],
            ':activate' => 1
        ));
        if ($success) {
            $_SESSION['messages']['success'][] = 'Inverser';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement';
        }

        header('location:./event.php');
        exit();
    }

    // EDITER LES EVENTS - Requête pour récupèrer les données des events et l'afficher dans le formulaire
    if (isset($_GET['a']) && $_GET['a'] == 'edit' && isset($_GET['i'])) {
        $eventById = execute("SELECT * FROM event WHERE id_event=:id_event", array(
            ':id_event' => $_GET['i']
        ))->fetch(PDO::FETCH_ASSOC);
    }

    // SUPPRIME UN ENREGISTREMENT DE EVENT ET CASCADE SUR LES TABLES LIES
    if (isset($_GET['a']) && $_GET['a'] == 'del' && isset($_GET['i'])) {
        // Retourne tous les évenements
        $eventToDelete = execute("SELECT * FROM event e INNER JOIN event_content ec ON e.id_event=ec.id_event INNER JOIN content c ON ec.id_content=c.id_content INNER JOIN event_media ev ON e.id_event=ev.id_event INNER JOIN media m ON ev.id_media=m.id_media INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE e.id_event=:id_event", [
            ':id_event' =>  $_GET['i']
        ])->fetch(PDO::FETCH_ASSOC);


        // Supprime l'enregistrement de la table event_content (id_event_content)
        execute("DELETE FROM event_content WHERE id_event_content=:id_event_content", array(
            ':id_event_content' =>  $eventToDelete['id_event_content']
        ));

        // Supprime l'enregistrement de la table content (id_content)
        execute("DELETE FROM content WHERE id_content=:id_content", array(
            ':id_content' => $eventToDelete['id_content']
        ));

        // Supprime l'enregistrement de la table event_media(id_event_media)
        execute("DELETE FROM event_media WHERE id_event_media=:id_event_media", array(
            ':id_event_media' =>  $eventToDelete['id_event_media']
        ));

        // Supprime l'enregistrement de la table media(id_media)
        execute("DELETE FROM media WHERE id_media=:id_media", array(
            ':id_media' => $eventToDelete['id_media']
        ));

        // Supprime l'enregistrement de la table event (id_event)
        $success = execute("DELETE FROM event WHERE id_event=:id_event", array(
            ':id_event' => $eventToDelete['id_event']
        ));

        // Supprime le fichier
        if ($eventToDelete['type_media_type'] == 'file') {
            unlink('../assets/upload/' . $eventToDelete['title_media_type'] . '/' . $eventToDelete['title_media']);
        }


        if ($success) {
            $_SESSION['messages']['success'][] = 'Evènement supprimé';
        } else {
            $_SESSION['messages']['danger'][] = 'Problème de traitement, veuillez réessayer';
        }

        header('location:./event.php');

        exit();
    }
}

// OBTENIR LA LISTE DES EVENTS
$events = execute("SELECT * FROM event e LEFT JOIN event_content ec ON e.id_event=ec.id_event LEFT JOIN content c ON ec.id_content=c.id_content INNER JOIN event_media ev ON e.id_event=ev.id_event INNER JOIN media m ON ev.id_media=m.id_media")->fetchAll(PDO::FETCH_ASSOC);

// CHARGEMENT DU HEADER 
require_once '../inc/backheader.inc.php';
?>

<div class="container">
    <h1 class="text-center mb-5">Gestion des évènements</h1>
    <div class="row mb-5">
        <div class="col-12 border mb-3 p-3" style="background-color: #869f7136;">
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex mb-3">
                    <?php if (isset($teamById) && !empty($teamById)) { ?>
                        <i class="far fa-edit text-info fa-2x me-2"></i>
                        <h3>Modifier un évènement</h3>
                    <?php } else { ?>
                        <i class="far fa-plus-square text-success fa-2x me-2"></i>
                        <h3>Ajouter un évènement</h3>
                    <?php } ?>
                </div>

                <!-- DATE DE DEBUT -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="start_date_event" class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="start_date_event" name="start_date_event" value="<?= $eventById['start_date_event
                    '] ?? '' ?>">
                    <small class="text-danger"><?= $dateDebut_error  ?? ""; ?></small>
                </div>

                <!-- DATE DE FIN -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="end_date_event" class="form-label">Date de fin</label>
                    <input type="date" class="form-control" id="end_date_event" name="end_date_event" value="<?= $eventById['end_date_event
                    '] ?? '' ?>">
                    <small class="text-danger"><?= $dateFin_error  ?? ""; ?></small>
                </div>

                <!-- AVATAR + ALT -->
                <div class="p-3 mb-3 border border-light">
                    <h5>Choisir un avatar</h5>
                    <label for="title_media" class="form-label">Fichier a télécharger</label>
                    <input onchange="loadFile()" name="title_media" type="file" class="form-control" id="title_media">
                    <div class="text-center">
                        <img id="image" class="img-fluid mt-3" alt="Evènement" width="200">
                    </div>
                    <small class="text-danger"><?= $avatar_error ?? ""; ?></small>
                </div>

                <!-- TITRE DU CONTENU POUR L'EVENEMENT -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="end_date_event" class="form-label">Titre de l'évènement</label>
                    <input type="text" class="form-control" id="title_content" name="title_content" value="<?= $eventById['title_content
                    '] ?? '' ?>">
                    <small class="text-danger"><?= $dateFin_error  ?? ""; ?></small>
                </div>

                <!-- CONTENT -->
                <div class="mb-3">
                    <small class="text-danger">*</small>
                    <label for="description_content" class="form-label">Description</label>
                    <textarea name="description_content" class="form-control" id="description_content" rows="3"><?= $eventById['description_content'] ?? '' ?></textarea>
                    <small class="text-danger"><?= $commentaires_error ?? ""; ?></small>
                    <input name="id_content" value="<?= $contentById['id_content'] ?? '' ?>" type="hidden">
                </div>

                <!-- SOUMISSION DU FORMULAIRE -->
                <div class="d-flex flex-column">
                    <?php if (isset($teamById) && !empty($teamById)) { ?>
                        <button type="submit" class="btn btn-lg btn-primary me-2">Editer</button>
                        <a class="btn btn-outline-secondary" href="<?= BASE_PATH . 'back/event.php' ?>">
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
                <h4 class="mb-3">Evènement</h4>
            </div>
            <p>Sélectionnez l'évènement a mettre en avant</p>

            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Date de début</th>
                            <th scope="col">Date de fin</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // requete pour retourner les types de média
                        foreach ($events as $key => $event) { ?>
                            <tr>
                                <td><?= $event['start_date_event'] ?></td>
                                <td><?= $event['end_date_event'] ?></td>
                                <td><?= $event['title_content'] ?></td>
                                <td>
                                    <small><?= $event['title_media'] ?></small><br>
                                    <img src="<?= BASE_PATH . 'assets/upload/avatarEvent/' . $event['title_media'] ?>" alt="<?= $event['title_media'] ?>" width="100">
                                </td>
                                <td><?= $event['description_content'] ?></td>
                                <td>
                                    <div class="d-flex">
                                        <!-- <a href="<?= BASE_PATH . 'back/event.php?a=edit&i=' . $event['id_event']; ?>" class="btn btn-outline-success me-2">
                                            <i class="far fa-edit"></i>
                                        </a> -->
                                        <?php
                                        if ($event['activate']) { ?>
                                            <a href="<?= BASE_PATH . 'back/event.php?a=activate&i=' . $event['id_event']; ?>" class="btn btn-outline-info me-2" title="Désactiver cet évenement">
                                                <i class="fas fa-thumbs-down"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?= BASE_PATH . 'back/event.php?a=activate&i=' . $event['id_event']; ?>" class="btn btn-outline-success me-2" title="Activer cet évenement">
                                                <i class="fas fa-thumbs-up"></i>
                                            </a>

                                        <?php } ?>

                                        <a href="<?= BASE_PATH . 'back/event.php?a=del&i=' . $event['id_event']; ?>" class="btn btn-outline-danger">
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