<?php
// Requetes/I_Compte/QueriesCompte.php

require_once __DIR__ . '/../AppConnection.php';

/**
 * Récupère tous les utilisateurs
 * @return array
 */
function getAllUtilisateur() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, nom, prenom, username FROM i_compte");
    return $stmt->fetchAll();
}

/**
 * Récupère un utilisateur par ID
 * @param int $id
 * @return array|null
 */
function getUtilisateurByID($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, nom, prenom, username FROM i_compte WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
/**
 * Récupère un utilisateur par recherche sur nom, prénom ou username
 * @param string $search
 * @return array
 */
function getUtilisateurBySearch($search) {
    global $pdo;
    $stmt = $pdo->prepare(
        "SELECT id, nom, prenom, username 
         FROM i_compte 
         WHERE nom LIKE ? OR prenom LIKE ? OR username LIKE ?"
    );
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
function addUtilisateur($nom, $prenom, $username, $motdepasse) {
    global $pdo;

    // hash du mot de passe
    $hashedPassword = hash('sha256', $motdepasse);

    $stmt = $pdo->prepare("INSERT INTO i_compte (nom, prenom, username, motdepasse) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nom, $prenom, $username, $hashedPassword]);
}

/**
 * Vérifie la connexion d'un utilisateur
 * @param string $username
 * @param string $motdepasse
 * @return array|false   retourne les infos utilisateur si OK, sinon false
 */
function connexionUtilisateur($username, $motdepasse) {
    global $pdo;

    // Re-hash du mot de passe entré
    $hashedPassword = hash('sha256', $motdepasse);

    $stmt = $pdo->prepare("SELECT a.id, a.nom, a.prenom, a.username, b.solde 
                           FROM i_compte a
                           LEFT JOIN t_solde b ON a.id = b.FK_idCompte
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
function deleteUtilisateur($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM i_compte WHERE id = ?");
    return $stmt->execute([$id]);
}
?>