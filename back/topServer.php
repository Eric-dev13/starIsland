<?php

if (!empty($_POST)) {
    $error = false;

    var_dump($_POST);

    // si pas de value pour la note alors note est 0
    if (empty($_POST['top-server_rating'])) {
        $rating = 0;
    } 

    // VALIDATOR : si pas de value pour les commentaires alors on remonte une erreur
    if(empty($_POST['top-server_comment'])){
        $topServerComment = 'Commentaire obligatoire ?';
        $error = true;
    }

    if (!$error) {
        // request
    } else {
        header('location:./');
    }
}

?>