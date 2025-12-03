<?php

require_once __DIR__ . '/../AppConnection.php';

// Recup les id artiste pour savoir lesquels mettre lors d'un ajout de solde
function getIdArtiste() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id,username FROM i_artiste");
    $stmt->execute();
    return $stmt->fetchAll();
}
?>