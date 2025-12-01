<?php
require_once __DIR__ . '/QueriesArtiste.php';

$result = null;

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'getAll':
            $result = getAllArtiste();
            break;

        case 'getById':
            $id = $_POST['id'] ?? 0;
            $result = getArtisteByID($id);
            break;

        case 'getBySearch':
            $search = $_POST['search'] ?? '';
            $result = getArtisteBySearch($search);
            break;
        case 'addArtiste':
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $username = $_POST['username'] ?? '';
            $motdepasse = $_POST['motdepasse'] ?? '';
            $result = addArtiste($nom, $prenom, $username, $motdepasse) ? "Artiste ajouté !" : "Erreur lors de l'ajout";
            break;

        case 'connexion':
            $username = $_POST['username'] ?? '';
            $motdepasse = $_POST['motdepasse'] ?? '';
            $user = connexionArtiste($username, $motdepasse);
            $result = $user ?: "Identifiants incorrects";
            break;

        case 'delete':
            $id = $_POST['id'] ?? 0;
            $result = deleteArtiste($id) ? "Artiste supprimé !" : "Erreur lors de la suppression";
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
    <h1>TABLE <span style="color:#0000FE;font-weight:bold;">I_ARTISTE</span></h1>

    <!-- Récupérer tous les artiste -->
    <form method="post">
        <input type="hidden" name="action" value="getAll">
        <button type="submit">Afficher tous les artiste</button>
    </form>

    <!-- Récupérer un artiste par ID -->
    <form method="post">
        <input type="hidden" name="action" value="getById">
        <label>ID :</label>
        <input type="number" name="id" required>
        <button type="submit">Chercher par ID</button>
    </form>

    <!-- Récupérer un artiste par nom -->
    <form method="post">
        <input type="hidden" name="action" value="getBySearch">
        <label>Rechercher :</label>
        <input type="text" name="search" required>
        <button type="submit">Chercher</button>
    </form>

    <!-- Ajouter un artiste -->
    <form method="post">
        <input type="hidden" name="action" value="addArtiste">
        <label>Nom :</label> <input type="text" name="nom" required><br>
        <label>Prénom :</label> <input type="text" name="prenom" required><br>
        <label>Username :</label> <input type="text" name="username" required><br>
        <label>Mot de passe :</label> <input type="password" name="motdepasse" required><br>
        <button type="submit">Ajouter artiste</button>
    </form>

    <!-- Connexion artiste -->
    <form method="post">
        <input type="hidden" name="action" value="connexion">
        <label>Username :</label> <input type="text" name="username" required><br>
        <label>Mot de passe :</label> <input type="password" name="motdepasse" required><br>
        <button type="submit">Connexion</button>
    </form>

    <!-- Supprimer un artiste -->
    <form method="post">
        <input type="hidden" name="action" value="delete">
        <label>ID :</label> <input type="number" name="id" required>
        <button type="submit">Supprimer artiste</button>
    </form>

    <!-- Résultat -->
    <?php if ($result !== null): ?>
        <h2>Résultat :</h2>
        <pre><?php echo is_array($result) ? json_encode($result, JSON_PRETTY_PRINT) : $result; ?></pre>
    <?php endif; ?>
</body>
</html>
