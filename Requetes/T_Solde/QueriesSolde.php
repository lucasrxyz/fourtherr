<?php
// Requetes/I_Compte/QueriesCompte.php

require_once __DIR__ . '/../AppConnection.php';

function getAllSolde() {
    global $pdo;
    $stmt = $pdo->query("
        SELECT
            a.id,
            a.solde,

            b.id AS idArtiste,
            b.nom AS nomArtiste,
            b.prenom AS prenomArtiste,
            b.username AS usernameArtiste,

            c.id AS idCompte,
            c.nom AS nomCompte,
            c.prenom AS prenomCompte,
            c.username AS usernameCompte
            
        FROM t_solde a
        LEFT JOIN i_artiste b ON a.FK_idArtiste = b.id
        LEFT JOIN i_compte c ON a.FK_idCompte = c.id
    ");
    return $stmt->fetchAll();
}
function getSoldeArtiste($artisteId) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            a.id,
            a.solde,
            b.id AS idArtiste,
            b.nom,
            b.prenom,
            b.username
        FROM t_solde a
        LEFT JOIN i_artiste b ON a.FK_idArtiste = b.id
        WHERE a.FK_idArtiste = :artisteId
    ");
    $stmt->execute([":artisteId" => $artisteId]);
    return $stmt->fetchAll();
}

function getSoldeCompte($idCompte) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT
            a.id,
            a.solde,
            b.id AS idArtiste,
            b.nom,
            b.prenom,
            b.username
        FROM t_solde a
        LEFT JOIN i_artiste b ON a.FK_idCompte = b.id
        WHERE a.FK_idCompte = :idCompte
    ");
    $stmt->execute([":idCompte" => $idCompte]);
    return $stmt->fetchAll();
}

function insertNewSolde($solde, $fkCompte, $fkArtiste) {
    global $pdo;
    $stmt = $pdo->prepare("
        INSERT INTO t_solde (solde, FK_idCompte, FK_idArtiste)
        VALUES (:solde, :fkCompte, :fkArtiste)
    ");
    $stmt->execute([
        ":solde" => $solde,
        ":fkCompte" => $fkCompte,
        ":fkArtiste" => $fkArtiste,
    ]);
    return $pdo->lastInsertId();
}

function deleteSoldeById($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM t_solde WHERE id = :id");
    $stmt->execute([":id" => $id]);
    return $stmt->rowCount();
}
?>