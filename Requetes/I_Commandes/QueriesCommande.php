<?php
// Requetes/I_Commandes/QueriesCommande.php
require_once __DIR__ . '/../AppConnection.php';

/**
 * Récupère toutes les commandes
 * flemme de faire une requete préparée car pas d'input utilisateur
 * @return array
 */
function getAllCommandes() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT 
            c.idNumCommande, 
            c.dateCommande, 
            c.description,
            c.prix,
            c.statut,
            c.FK_idCompte,
            a.nom AS nomCompte,
            a.username AS usernameCompte,
            c.FK_idArtiste,
            b.nom AS nomArtiste,
            b.username AS usernameArtiste
        FROM I_commandes c
        LEFT JOIN i_compte a ON c.FK_idCompte = a.id
        LEFT JOIN i_artiste b ON c.FK_idArtiste = b.id
    ");
    return $stmt->fetchAll();
}

/**
 * Récupère commandes par artiste ID
 */
function getCommandeByArtisteID($artisteId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            c.idNumCommande, 
            c.dateCommande, 
            c.description,
            c.prix,
            c.statut,
            c.FK_idCompte,
            a.nom AS nomCompte,
            a.username AS usernameCompte,
            c.FK_idArtiste,
            b.nom AS nomArtiste,
            b.username AS usernameArtiste
        FROM I_commandes c
        LEFT JOIN i_compte a ON c.FK_idCompte = a.id
        LEFT JOIN i_artiste b ON c.FK_idArtiste = b.id
        WHERE c.FK_idArtiste = :artisteId
    ");
    $stmt->execute([":artisteId" => $artisteId]);
    return $stmt->fetchAll();
}

/**
 * Récupère commande par numéro de commande
 */
function getCommandeByIdNumCommande($idNumCommande) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            c.idNumCommande, 
            c.dateCommande, 
            c.description,
            c.prix,
            c.statut,
            c.FK_idCompte,
            a.nom AS nomCompte,
            a.username AS usernameCompte,
            c.FK_idArtiste,
            b.nom AS nomArtiste,
            b.username AS usernameArtiste
        FROM I_commandes c
        LEFT JOIN i_compte a ON c.FK_idCompte = a.id
        LEFT JOIN i_artiste b ON c.FK_idArtiste = b.id
        WHERE c.idNumCommande = :idNumCommande
    ");
    $stmt->execute([":idNumCommande" => $idNumCommande]);
    return $stmt->fetchAll();
}

/**
 * Rechercher commandes par nom/prenom compte
 */
function searchCommandeByCompte($searchTerm) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            c.idNumCommande,
            c.dateCommande,
            c.description,
            c.prix,
            c.statut,
            c.FK_idCompte,
            a.nom AS nomCompte,
            a.username AS usernameCompte,
            c.FK_idArtiste,
            b.nom AS nomArtiste,
            b.username AS usernameArtiste
        FROM I_commandes c
        LEFT JOIN i_compte a ON c.FK_idCompte = a.id
        LEFT JOIN i_artiste b ON c.FK_idArtiste = b.id
        WHERE a.nom LIKE :term OR a.username LIKE :term
    ");
    $stmt->execute([":term" => "%$searchTerm%"]);
    return $stmt->fetchAll();
}

/**
 * Rechercher commandes par nom/prenom artiste
 */
function searchCommandeByArtiste($searchTerm) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT 
            c.idNumCommande,
            c.dateCommande,
            c.description,
            c.prix,
            c.statut,
            c.FK_idCompte,
            a.nom AS nomCompte,
            a.username AS usernameCompte,
            c.FK_idArtiste,
            b.nom AS nomArtiste,
            b.username AS usernameArtiste
        FROM I_commandes c
        LEFT JOIN i_compte a ON c.FK_idCompte = a.id
        LEFT JOIN i_artiste b ON c.FK_idArtiste = b.id
        WHERE b.nom LIKE :term OR b.username LIKE :term
    ");
    $stmt->execute([":term" => "%$searchTerm%"]);
    return $stmt->fetchAll();
}

/**
 * Insérer une nouvelle commande
 */
function insertCommande($description, $prix, $fkCompte, $fkArtiste, $statut = "non commencé") {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO i_commandes (description, prix, statut, dateCommande, FK_idCompte, FK_idArtiste)
        VALUES (:description, :prix, :statut, NOW(), :fkCompte, :fkArtiste)
    ");
    $stmt->execute([
        ":description" => $description,
        ":prix" => $prix,
        ":statut" => $statut,
        ":fkCompte" => $fkCompte,
        ":fkArtiste" => $fkArtiste
    ]);
    return $pdo->lastInsertId();
}

/**
 * Supprimer une commande par ID
 */
function deleteCommandeById($idNumCommande) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM i_commandes WHERE idNumCommande = :idNumCommande");
    $stmt->execute([":idNumCommande" => $idNumCommande]);
    return $stmt->rowCount(); // retourne 1 si supprimé, 0 sinon
}
