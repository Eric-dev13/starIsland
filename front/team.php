<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php';

if (!empty($_GET)) {
    if (isset($_GET['r']) && !empty($_GET['r'])) {
        if ($_GET['r'] == 'Tous') {
            $teams = execute("SELECT * FROM team")->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $teams = execute("SELECT * FROM team WHERE role_team = :role_team ", [
                ':role_team' => $_GET['r']
            ])->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} else {
    $teams = execute("SELECT * FROM team")->fetchAll(PDO::FETCH_ASSOC);
}

function active(string $name) {
    if ( isset($_GET['r']) && $_GET['r'] == $name){
        return 'active';
    }
    return '';
}

?>


<section class="team flex-grow-1">
    <h1 class="text-center text-white my-5">L'équipe</h1>
    <div class="container">
        <div class="d-flex justify-content-center btn-teams">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <a href="<?= BASE_PATH . 'front/team.php?r=Tous'; ?>">
                    <button type="button" class="<?php if ( !isset($_GET['r']) || $_GET['r'] == 'Tous'){echo 'active';} ?> btn btn-outline-light">Tous</button>
                </a>
                <a href="<?= BASE_PATH . 'front/team.php?r=Admins'; ?>">
                    <button type="button" class="<?= active('Admins') ?> btn btn-outline-light">Admins</button>
                </a>
                <a href="<?= BASE_PATH . 'front/team.php?r=Staff/Modos'; ?>">
                    <button type="button" class="<?= active('Staff/Modos') ?> btn btn-outline-light">Staff/Modos</button>
                </a>
                <a href="<?= BASE_PATH . 'front/team.php?r=Développeurs'; ?>">
                    <button type="button" class="<?= active('Développeurs') ?> btn btn-outline-light">Développeurs</button>
                </a>
                <a href="<?= BASE_PATH . 'front/team.php?r=Mappers'; ?>">
                    <button type="button" class="<?= active('Mappers') ?> btn btn-outline-light">Mappers</button>
                </a>
                <a href="<?= BASE_PATH . 'front/team.php?r=Helpers'; ?>">
                    <button type="button" class="<?= active('Helpers') ?> btn btn-outline-light">Helpers</button>
                </a>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center flex-wrap my-5">
            <!-- Requete pour retourner les types de média -->
            <?php foreach ($teams as $key => $team) { ?>
                <div class="container-resizable-avatar">
                    <h5><?= $team['nickname_team'] ?></h5>
                    <small><?= $team['role_team'] ?></small>
                    <?php
                    $medias = execute("SELECT m.*, mt.* FROM team_media tm INNER JOIN media m ON tm.id_media=m.id_media INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type WHERE tm.id_team=:id_team", array(
                        ':id_team' => $team['id_team']
                    ))->fetchAll(PDO::FETCH_ASSOC);
                    $pathImage = null;
                    $alt = null;
                    $links = [];
                    foreach ($medias as $key => $media) {
                        if ($media['type_media_type'] == 'file') {
                            $pathImage = '../assets/upload/' . $media['title_media_type'] . '/' . $media['title_media'];
                            $alt = $media['name_media'];
                        } else {
                            $links[] = $media['title_media'];
                        }
                    } ?>
                    <div class="group-link">
                        <div class="link">
                            <?php
                            foreach ($links as $link) { ?>
                                <a href="<?= $link ?>" target="_blank" ><img src="<?= BASE_PATH . 'assets/img/icon/link.png' ?>" alt="github" width=50></a>
                            <?php } ?>
                        </div>
                        <img src="<?= $pathImage ?>" alt="<?= $alt ?>" class="avatar">
                    </div>
                </div>

                <div class="container-resizable-avatar">
                    <div class="avatar-hidden"></div>
                </div>

            <?php
            }
            ?>
        </div>

        <div class="reseaux-sociaux mb-5">
            <a id="facebook" class="reseaux" href="https://www.facebook.com/StarIslandfr-108004258577047">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_facebook.png' ?>" alt="facebook">
            </a>
            <a id="tiktok" class="reseaux" href="https://www.tiktok.com/@star.island?lang=fr">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/Logo_tiktok.png' ?>" alt="tiktok">
            </a>
            <a id="twitter" class="reseaux" href="https://twitter.com/StarIslandfr">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_twitter.png' ?>" alt="twitter">
            </a>
            <div id="discorde" class="reseaux">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/icons8-discorde.png' ?>" alt="discorde">
            </div>
            <a id="youtube" class="reseaux" href="https://www.youtube.com/channel/UCI7G6fNN-17g1_tOVMKRCpQ">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_youtube.png' ?>" alt="youtube">
            </a>
            <a id="twitch" class="reseaux" href="#">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_twitch.png' ?>" alt="logo_twitch">
            </a>
            <a id="instagram" class="reseaux" href="https://www.instagram.com/starisland.fr/">
                <img src="<?= BASE_PATH . 'assets/img/reseaux/logo_Instagram.png' ?>" alt="instagram">
            </a>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {

    });
</script>

<?php require_once '../inc/footer.inc.php'; ?>