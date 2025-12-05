<?php
require_once __DIR__ . '../../../Requetes/T_Solde/QueriesSolde.php';
require_once __DIR__ . '../../../Requetes/I_Commandes/QueriesCommande.php';

session_start();

// Protection de la page
if (!isset($_SESSION['user'])) {
    header("Location: FourtherrLogin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'addSoldeToArtiste':
            $id = $_POST['id'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $result = addSoldeArtiste($id, $amount) . " | " . htmlspecialchars($amount) . " ajouté(s) à compte pour ID " . htmlspecialchars($id);
            break;

        case 'addSoldeToCompte':
            $id = $_POST['id'] ?? 0;
            $amount = $_POST['amount'] ?? 0;
            $result = addSoldeCompte($id, $amount) . " | " . htmlspecialchars($amount) . " ajouté(s) à compte pour ID " . htmlspecialchars($id);
            break;

        case 'getCommandeArtiste':
            $artisteId = $_POST['artisteId'] ?? null;
            if ($artisteId) $result = getCommandeByArtisteID($artisteId);
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
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Fourtherr</title>
    <link rel="stylesheet" href="../../Styles/page_style.css">

    <script src="../../Scripts/HandleNotifCompte.js" defer></script>
    <script src="../../Scripts/HandleNotifSolde.js" defer></script>
    <!-- "defer" pour que le script s'éxécute après le chargement de l'html -->
    <script src="../../Scripts/HandleDivRechargerSolde.js" defer></script>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <strong>FOURTHERR</strong>

        <div class="navbar-right">
            <a style="color:white;margin-right: 14px;">
                <?php 
                echo htmlspecialchars($_SESSION['user']['prenom']); 
                echo "&nbsp;"; 
                echo htmlspecialchars($_SESSION['user']['nom']);
                echo "&nbsp;&nbsp;"; 
                echo "<span style='color:#fdd2a0ff; font-weight: bold;'>" . ucfirst(htmlspecialchars($_SESSION['type']));
                ?>
            </a>
            <a href="solde.php" class="sidebar-btn navbar-btn">Solde</a>
            <a href="../../Controllers/logoutCall.php" class="sidebar-btn navbar-btn">Déconnexion</a>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'artiste'): ?>
        <!-- Mes Revenus -->
        <div class="sidebar-group">
            <div class="sidebar-group-title">Mes Revenus</div>

            <div class="sidebar-item">
                <a href="PageAccueil.php" class="sidebar-btn">Dashboard</a>
            </div>

            <div class="sidebar-item">
                <a href="#" class="sidebar-btn">Mes Clients</a>
            </div>
        </div>
        <?php endif; ?>
        <!-- Artistes -->
        <div class="sidebar-group">
            <div class="sidebar-group-title">Artistes</div>
            <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'artiste'): ?>
            <div class="sidebar-item">
                <a href="#" class="sidebar-btn">Mon Portofolio</a>
            </div>
            <?php endif; ?>
            <div class="sidebar-item">
                <a href="./Discover/Decouvrir.php" class="sidebar-btn">Découvrir</a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h2 style="margin-left:16px;">Découvrez les oeuvres de nos artistes!</h2>

    </div>
</body>
</html>