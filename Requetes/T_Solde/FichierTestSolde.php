<?php
require_once __DIR__ . '/QueriesSolde.php';

$result = null;

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {

        // pour recup les id compte et id artiste
        case 'getIdArtiste':
            $result = getIdArtiste();
            break;
        case 'getIdCompte':
            $result = getIdCompte();
            break;

        case 'getAllSolde':
            $result = getAllSolde();
            break;

        case 'getSoldeByArtiste':
            $artisteId = $_POST['artisteId'] ?? 0;
            $result = getSoldeArtiste($artisteId);
            break;

        case 'getSoldeByCompte':
            $idCompte = $_POST['idCompte'] ?? 0;
            $result = getSoldeCompte($idCompte);
            break;

        case 'insertSolde':
        $solde = $_POST['solde'] ?? null;

        $fkCompte  = $_POST['fkCompte']  !== "" ? $_POST['fkCompte']  : null;
        $fkArtiste = $_POST['fkArtiste'] !== "" ? $_POST['fkArtiste'] : null;
            
        if ($solde !== null) {
            $lastId = insertNewSolde($solde, $fkCompte, $fkArtiste);
            $result = ["message" => "solde correctement inséré", "id" => $lastId];
        } else {
            $result = ["error" => "solde obligatoire"];
        }
        break;

        case 'deleteSolde':
            $id = $_POST['id'] ?? 0;
            $result = deleteSoldeById($id) . " row(s) deleted";
            break;
        
        case 'addSoldeToArtiste':
            $id = $_POST['id'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $result = addSoldeArtiste($id, $amount) . " | " . htmlspecialchars($amount) . " ajouté(s) à artiste pour ID " . htmlspecialchars($id);
            break;

        case 'addSoldeToCompte':
            $id = $_POST['id'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $result = addSoldeCompte($id, $amount) . " | " . htmlspecialchars($amount) . " ajouté(s) à compte pour ID " . htmlspecialchars($id);
            break;

        case 'deleteAmountFromSoldeArtiste':
            $id = $_POST['id'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $result = delSoldeAmountArtiste($id, $amount) . " | " . htmlspecialchars($amount) . " supprimés(s) à compte pour ID " . htmlspecialchars($id);
            break;

        case 'deleteAmountFromSoldeCompte':
            $id = $_POST['id'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $result = delSoldeAmountCompte($id, $amount) . " | " . htmlspecialchars($amount) . " ajouté(s) à compte pour ID " . htmlspecialchars($id);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Queries Compte</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        input { margin: 5px 0; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>
    <h1>TABLE <span style="color:#0000FE;font-weight:bold;">T_SOLDE</span></h1>

    <!-- Récupérer tous les solde -->
    <form method="post">
        <input type="hidden" name="action" value="getAllSolde">
        <button type="submit">Éxécuter</button>
    </form>

    <!-- Récupérer solde par ID artiste -->
    <form method="post">
        <input type="hidden" name="action" value="getSoldeByArtiste">
        <label>ID Artiste :</label>
        <input type="number" name="artisteId" required>
        <button type="submit">Éxécuter</button>
    </form>

    <!-- Récupérer solde par ID compte -->
    <form method="post">
        <input type="hidden" name="action" value="getSoldeByCompte">
        <label>ID Compte :</label>
        <input type="number" name="idCompte" required>
        <button type="submit">Éxécuter</button>
    </form>

    
    <form method="post">
        <input type="hidden" name="action" value="insertSolde"><br>
        <label>Solde :</label>
        <input type="number" name="solde" step="0.01" required><br>
        <label>Compte ID :</label>
        <input type="number" name="fkCompte"><br>
        <label>Artiste ID :</label>
        <input type="number" name="fkArtiste"><br>
        <button type="submit">Exécuter</button>
    </form>

    <!-- Supprimer solde par ID Solde -->
    <form method="post">
        <input type="hidden" name="action" value="deleteSolde">
        <label>ID Solde :</label>
        <input type="number" name="id" required>
        <button type="submit">Éxécuter</button>
    </form>

    <form method="post" style="border: 2px solid #0000FE;">
        <input type="hidden" name="action" value="getIdCompte">
        <button type="submit">IDs compte</button>
    </form>
    <form method="post" style="border: 2px solid #0000FE;">
        <input type="hidden" name="action" value="getIdArtiste">
        <button type="submit">IDs artiste</button>
    </form>

    <!-- Ajouter solde a artiste-->
    <b> Ajouter solde artiste </b>
    <form method="post">
        <input type="hidden" name="action" value="addSoldeToArtiste">
        <label>ID :</label>
        <input type="number" name="id" required><br>
        <label>Montant :</label>
        <input type="number" step="0.01" name="amount" required><br>
        <button type="submit">Éxécuter</button>
    </form>

    <!-- Ajouter solde a compte-->
    <b> Ajouter solde compte </b>
    <form method="post">
        <input type="hidden" name="action" value="addSoldeToCompte">
        <label>ID :</label>
        <input type="number" name="id" required><br>
        <label>Montant :</label>
        <input type="number" step="0.01" name="amount" required><br>
        <button type="submit">Éxécuter</button>
    </form>

    <!-- Résultat -->
    <?php if ($result !== null): ?>
        <h3><span style="color:#0000FE"><b>JSON</b></span> response body</h3>
        <pre><?php echo is_array($result) ? json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $result; ?></pre>
    <?php endif;
