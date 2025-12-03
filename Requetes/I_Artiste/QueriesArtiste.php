<?php

require_once __DIR__ . '/../AppConnection.php';

/**
 * Récupère tous les utilisateurs
 * @return array
 */
function getAllArtiste() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, nom, prenom, username FROM i_artiste");
    return $stmt->fetchAll();
}

/**
 * Récupère un utilisateur par ID
 * @param int $id
 * @return array|null
 */
function getArtisteByID($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, nom, prenom, username FROM i_artiste WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
/**
 * Récupère un artiste par recherche (nom, prénom, username)
 * @param string $search
 * @return array
 */
function getArtisteBySearch($search) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT id, nom, prenom, username 
        FROM i_artiste 
        WHERE nom LIKE ? OR prenom LIKE ? OR username LIKE ?
    ");
    $like = '%' . $search . '%';
    $stmt->execute([$like, $like, $like]);
    return $stmt->fetch();
}

/**
 * Ajoute un utilisateur avec mot de passe hashé en SHA-256
 * @param string $nom
 * @param string $prenom
 * @param string $username
 * @param string $motdepasse
 * @return bool
 */
function addArtiste($nom, $prenom, $username, $motdepasse) {
    global $pdo;

    // hash du mot de passe
    $hashedPassword = hash('sha256', $motdepasse);

    $stmt = $pdo->prepare("INSERT INTO i_artiste (nom, prenom, username, motdepasse) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nom, $prenom, $username, $hashedPassword]);
}

/**
 * Vérifie la connexion d'un utilisateur
 * @param string $username
 * @param string $motdepasse
 * @return array|false   retourne les infos utilisateur si OK, sinon false
 */
function connexionArtiste($username, $motdepasse) {
    global $pdo;

    // Re-hash du mot de passe entré
    $hashedPassword = hash('sha256', $motdepasse);

    $stmt = $pdo->prepare("SELECT a.id, a.nom, a.prenom, a.username, b.solde 
                           FROM i_artiste a
                           LEFT JOIN t_solde b ON b.FK_idArtiste = a.id
                           WHERE username = ? AND motdepasse = ?");
    $stmt->execute([$username, $hashedPassword]);

    $user = $stmt->fetch();

    return $user ?: false; // renvoie false si pas trouvé
}


/**
 * Exemple pour supprimer un utilisateur
 * @param int $id
 * @return bool
 */
function deleteArtiste($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM i_artiste WHERE id = ?");
    return $stmt->execute([$id]);
}
?>