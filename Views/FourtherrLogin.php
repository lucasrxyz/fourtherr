<?php
require_once __DIR__ . '/../Requetes/I_Compte/QueriesCompte.php';
require_once __DIR__ . '/../Requetes/I_Artiste/QueriesArtiste.php';

session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['motdepasse'] ?? '';
    $type = $_POST['type'] ?? 'compte';

    if ($type === 'artiste') {
        $user = connexionArtiste($username, $password);
    } else {
        $user = connexionUtilisateur($username, $password);
    }

    if ($user) {

        // Stockage en session
        $_SESSION['user'] = $user;
        $_SESSION['type'] = $type;

        // 🚀 Redirection vers la page d'accueil
        header("Location: PageAccueil.php");
        exit;

    } else {
        $message = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Styles/login_style.css">
    <title>Connexion Fourtherr</title>
    </head>
<body>

    <div class="login-container">
        <h1>Connexion Fourtherr</h1>
        <form method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="motdepasse" placeholder="Mot de passe" required>
            <select name="type">
                <option value="compte">Compte utilisateur</option>
                <option value="artiste">Artiste</option>
            </select>
            <button type="submit">Se connecter</button>
        </form>

        <!-- Boutons vers les test -->
        <br>
        <div class="div-center">
           <button type="button" style="padding: 3px;" onclick="window.location.href='../Requetes/I_Artiste/FichierTestCompte.php'">I_Artiste</button>
           <button type="button" style="padding: 3px;" onclick="window.location.href='../Requetes/I_Commandes/FichierTestCommande.php'">I_Commandes</button>
           <button type="button" style="padding: 3px;" onclick="window.location.href='../Requetes/I_Compte/FichierTestCompte.php'">I_Compte</button>
           <button type="button" style="padding: 3px;" onclick="window.location.href='../Requetes/T_Solde/FichierTestSolde.php'">T_Solde</button>
        </div>

        <?php if($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

    </div>

</body>
</html>
