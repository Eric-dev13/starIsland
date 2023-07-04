<?php
require_once '../config/function.php';
require_once '../inc/header.inc.php';

// récupère tous les commentaires publier et validés par l'admin
$comments = execute("SELECT * FROM comment WHERE comment.publish = 1 ORDER BY id_comment DESC")->fetchAll(PDO::FETCH_ASSOC);

// Recupere la liste des avatars
$avatars = execute("SELECT * FROM media m INNER JOIN media_type mt ON m.id_media_type=mt.id_media_type where mt.title_media_type = :avatars",[
    ':avatars' => 'avatars'
])->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="allComment">
    <h1 class="text-center text-shadow pt-5">BIENVENUE SUR<br>STAR’ISLAND</h1>
    <div class="container ">
        <div class="row">
            <div class="col-12">
                <?php
                foreach ($comments as $key => $comment) {
                ?>
                    <div class="row d-flex justify-content-center <?php if ($key % 2) {
                                                                        echo "justify-content-md-start";
                                                                    } else {
                                                                        echo "justify-content-md-end";
                                                                    } ?> mb-3 p-2">
                        <div class="col-12 col-md-10 col-lg-8 col-xl-6 bg-light bg-opacity-50 <?php if ($key % 2) {
                                                                                                    echo "left";
                                                                                                } else {
                                                                                                    echo "right";
                                                                                                } ?> d-flex align-items-center justify-content-center border border-dark p-2">
                            <?php $randomizeAvatar = rand(0, count($avatars)-1); ?>             
                            <img class="rounded-circle" src="<?= BASE_PATH.'assets/upload/avatars/'.$avatars[$randomizeAvatar]['title_media'] ?>" alt="<?= $avatars[$randomizeAvatar]['name_media'] ?>" width=80>
                            <div class="ps-2">
                                <div class="d-flex justify-content-around p-2 mt-2">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $comment['rating_comment']) {
                                            echo "<i class='fas fa-star text-sun fa-2x'></i>";
                                        } else {
                                            echo "<i class='fas fa-star text-dark fa-2x'></i>";
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="mt-2 text-black">
                                    <p><?= $comment['comment_text'] ?></p>
                                    <small class="fw-bold">Publié le <?= $comment['publish_date_comment'] ?></small>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php require_once '../inc/footer.inc.php'; ?>