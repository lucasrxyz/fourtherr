<?php

require_once __DIR__ . '/../AppConnection.php';

// Recup les id artiste pour savoir lesquels mettre lors d'un ajout de solde
function getAllPortofolio() {
    global $pdo;
    $stmt = $pdo->prepare("
    SELECT 
        p.id,
        p.titre,
        p.description,
        p.image,
        p.FK_idArtiste,

        a.id,
        a.motdepasse,
        a.nom,
        a.prenom,
        a.username
    
    FROM t_portofolio p
    LEFT JOIN i_artiste a ON p.FK_idArtiste = a.id");
    $stmt->execute();
    return $stmt->fetchAll();
}
?>