<?php
require_once __DIR__ . '/QueriesCommande.php';

$result = null;

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {

        case 'getAll':
            $result = getAllCommandes();
            break;

        case 'getByArtisteID':
            $artisteId = $_POST['artisteId'] ?? null;
            if ($artisteId) $result = getCommandeByArtisteID($artisteId);
            break;

        case 'getByIDNumCommande':
            $numCommande = $_POST['numCommande'] ?? null;
            if ($numCommande) $result = getCommandeByIdNumCommande($numCommande);
            break;

        case 'searchCompte':
            $term = $_POST['searchTerm'] ?? '';
            if ($term) $result = searchCommandeByCompte($term);
            break;

        case 'searchArtiste':
            $term = $_POST['searchTerm'] ?? '';
            if ($term) $result = searchCommandeByArtiste($term);
            break;

        case 'insertCommande':
            $description = $_POST['description'] ?? '';
            $prix = $_POST['prix'] ?? 0;
            $fkCompte = $_POST['fkCompte'] ?? null;
            $fkArtiste = $_POST['fkArtiste'] ?? null;
            if ($description && $fkCompte && $fkArtiste) {
                $lastId = insertCommande($description, $prix, $fkCompte, $fkArtiste);
                $result = ["message" => "Commande insérée", "id" => $lastId];
            }
            break;

        case 'deleteCommande':
            $idNumCommande = $_POST['idNumCommande'] ?? null;
            if ($idNumCommande) {
                $deleted = deleteCommandeById($idNumCommande);
                $result = ["message" => "Commandes supprimées", "count" => $deleted];
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Queries Commandes</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        input, select { margin: 5px 0; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>

<h1>TABLE <span style="color:#0000FE;font-weight:bold;">I_COMMANDES</span></h1>

<!-- Tous les formulaires -->

<form method="post">
    <input type="hidden" name="action" value="getAll">
    <button type="submit">Afficher toutes les commandes</button>
</form>

<form method="post">
    <input type="hidden" name="action" value="getByArtisteID">
    <label>ID de l'artiste :</label>
    <input type="number" name="artisteId" required>
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <input type="hidden" name="action" value="getByIDNumCommande">
    <label>ID de la commande :</label>
    <input type="number" name="numCommande" required>
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <input type="hidden" name="action" value="searchCompte">
    <label>Rechercher par compte :</label>
    <input type="text" name="searchTerm" required>
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <input type="hidden" name="action" value="searchArtiste">
    <label>Rechercher par artiste :</label>
    <input type="text" name="searchTerm" required>
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <input type="hidden" name="action" value="insertCommande"><br>
    <label>Description :</label>
    <input type="text" name="description" required><br>
    <label>Prix :</label>
    <input type="number" name="prix" step="0.01" required><br>
    <label>Compte ID :</label>
    <input type="number" name="fkCompte" required><br>
    <label>Artiste ID :</label>
    <input type="number" name="fkArtiste" required><br>
    <button type="submit">Exécuter</button>
</form>

<form method="post">
    <input type="hidden" name="action" value="deleteCommande">
    <label>ID de la commande à supprimer :</label>
    <input type="number" name="idNumCommande" required>
    <button type="submit">Éxécuter</button>
</form>

<!-- Résultat -->
<?php if ($result !== null): ?>
    <h3><span style="color:#0000FE"><b>JSON</b></span> response body</h3>
    <pre><?php echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
<?php endif; ?>

</body>
</html>
