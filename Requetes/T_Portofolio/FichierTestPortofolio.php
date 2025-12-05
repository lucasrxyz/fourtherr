<?php
require_once __DIR__ . '/QueriesPortofolio.php';

$result = null;

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {

        case 'getAll':
            $result = getAllPortofolio();
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

<!-- Résultat -->
<?php if ($result !== null): ?>
    <h3><span style="color:#0000FE"><b>JSON</b></span> response body</h3>
    <pre><?php echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
<?php endif; ?>

</body>
</html>
