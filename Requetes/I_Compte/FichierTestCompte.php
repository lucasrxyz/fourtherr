<?php
require_once __DIR__ . '/QueriesCompte.php';

$result = null;

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'getAll':
            $result = getAllUtilisateur();
            break;

        case 'getById':
            $id = $_POST['id'] ?? 0;
            $result = getUtilisateurByID($id);
            break;

        case 'getBySearch':
            $search = $_POST['search'] ?? '';
            $result = getUtilisateurBySearch($search);
            break;

        case 'addUtilisateur':
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $username = $_POST['username'] ?? '';
            $motdepasse = $_POST['motdepasse'] ?? '';
            $result = addUtilisateur($nom, $prenom, $username, $motdepasse) ? "Utilisateur ajouté !" : "Erreur lors de l'ajout";
            break;

        case 'connexion':
            $username = $_POST['username'] ?? '';
            $motdepasse = $_POST['motdepasse'] ?? '';
            $user = connexionUtilisateur($username, $motdepasse);
            $result = $user ?: "Identifiants incorrects";
            break;

        case 'delete':
            $id = $_POST['id'] ?? 0;
            $result = deleteUtilisateur($id) ? "Utilisateur supprimé !" : "Erreur lors de la suppression";
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
    <h1>TABLE <span style="color:#0000FE;font-weight:bold;">I_COMPTE</span></h1>

    <!-- Récupérer tous les utilisateurs -->
    <form method="post">
        <input type="hidden" name="action" value="getAll">
        <button type="submit">Afficher tous les utilisateurs</button>
    </form>

    <!-- Récupérer un utilisateur par ID -->
    <form method="post">
        <input type="hidden" name="action" value="getById">
        <label>ID :</label>
        <input type="number" name="id" required>
        <button type="submit">Chercher par ID</button>
    </form>

    <!-- Récupérer un utilisateur par recherche (nom, prénom, username) -->
    <form method="post">
        <input type="hidden" name="action" value="getBySearch">
        <label>Recherche :</label>
        <input type="text" name="search" required>
        <button type="submit">Chercher</button>
    </form>

    <!-- Ajouter un utilisateur -->
    <form method="post">
        <input type="hidden" name="action" value="addUtilisateur">
        <label>Nom :</label> <input type="text" name="nom" required><br>
        <label>Prénom :</label> <input type="text" name="prenom" required><br>
        <label>Username :</label> <input type="text" name="username" required><br>
        <label>Mot de passe :</label> <input type="password" name="motdepasse" required><br>
        <button type="submit">Ajouter utilisateur</button>
    </form>

    <!-- Connexion utilisateur -->
    <form method="post">
        <input type="hidden" name="action" value="connexion">
        <label>Username :</label> <input type="text" name="username" required><br>
        <label>Mot de passe :</label> <input type="password" name="motdepasse" required><br>
        <button type="submit">Connexion</button>
    </form>

    <!-- Supprimer un utilisateur -->
    <form method="post">
        <input type="hidden" name="action" value="delete">
        <label>ID :</label> <input type="number" name="id" required>
        <button type="submit">Supprimer utilisateur</button>
    </form>

    <!-- Résultat -->
    <?php if ($result !== null): ?>
        <h2>Résultat :</h2>
        <pre><?php echo is_array($result) ? json_encode($result, JSON_PRETTY_PRINT) : $result; ?></pre>
    <?php endif;
