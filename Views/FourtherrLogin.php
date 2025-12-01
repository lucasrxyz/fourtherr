<?php
require_once __DIR__ . '/../Requetes/I_Compte/QueriesCompte.php';
require_once __DIR__ . '/../Requetes/I_Artiste/QueriesArtiste.php';

session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['motdepasse'] ?? '';
    $type = $_POST['type'] ?? 'compte'; // compte ou artiste

    if ($type === 'artiste') {
        $user = connexionArtiste($username, $password);
    } else {
        $user = connexionUtilisateur($username, $password);
    }

    if ($user) {
        $_SESSION['user'] = $user;
        $_SESSION['type'] = $type;
        $message = "Connexion réussie en tant que $type : " . htmlspecialchars($user['username']);
    } else {
        $message = "Identifiants incorrects pour $type.";
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
    <?php if($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
</div>

</body>
</html>
