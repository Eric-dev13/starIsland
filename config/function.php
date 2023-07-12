<?php
require_once 'Db.php';

function debug($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function execute(string $requete, array $data = [], $lastId = null)
{
    // boucle pour echapper les caractères speciaux (pour neutraliser les balise <style> ou <script>) en entité html et de même supprimer les espaces éventuels en début de fin de chaine de caractère
    foreach ($data as $marqueur => $valeur) {
        // ici on réaffecte à notre tableau $data
        // les nouvelles valeurs échappées et sans espaces pour chaque tour de boucle
        $data[$marqueur] = trim(htmlspecialchars($valeur));
    }
    $pdo = Db::getDB(); // connexion à la BDD provenant de Db.php
    $resultat = $pdo->prepare($requete); // on prépare la requête envoyée avec marqueur (:marqueur)

    $success = $resultat->execute($data); // on execute en passant notre tableau associatif de nos marqueurs avec leur valeurs

    if ($success) { // si tout s'est bien passé ($success renvoi true ou false)

        if ($lastId) { // si le paramètre optionnel $lastId est renseigné

            return $pdo->lastInsertId(); // on renvoie le dernier id inséré

        } else { // sinon on renvoi le jeu de résultat
            return $resultat;
        }
    } else { // on s'assure d'un retour même si le traitement a échoué

        return  false;
    }
}

function password_strength_check(string $password, int $min_len = 6, int $max_len = 15, bool $req_digit = true, bool $req_lower = true, bool $req_upper = true, bool $req_symbol = true)
{
    // Build regex string depending on requirements for the password
    $regex = '/^';
    if ($req_digit) {
        // Vérifie si au moins 1 chiffre
        $regex .= '(?=.*\d)';
    }
    if ($req_lower) {
        // Vérifie si au moins 1 lettre minuscule
        $regex .= '(?=.*[a-z])';
    }
    if ($req_upper) {
        // Vérifie si au moins 1 lettre majuscule
        $regex .= '(?=.*[A-Z])';
    }
    if ($req_symbol) {
        // $regex .= '(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]';
        // Vérifie si au moins l'un des caractères spéciaux '@', '$', '!', '%', '*', '?', ou '&' est présent dans la chaîne de caractères.
        $regex .= '(?=.*[@$!%*?&])';
    }
    $regex .= '.{' . $min_len . ',' . $max_len . '}$/';

    if (preg_match($regex, $password)) {
        return true;
    } else {
        return false;
    }
}

function connect()
{
    if (isset($_SESSION['user'])) {

        return true;
    } else {

        return false;
    }
}


function adminExist()
{
    try {
        $admin = execute("SELECT COUNT(*) FROM user")->fetch(PDO::FETCH_BOTH);
        if ($admin[0] > 0) {
            return true;
        }
        return false;
    } catch (\Throwable $th) {
        throw $th;
    }
}
