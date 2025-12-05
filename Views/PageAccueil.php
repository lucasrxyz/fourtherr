<?php
require_once __DIR__ . '/../Requetes/T_Solde/QueriesSolde.php';
require_once __DIR__ . '/../Requetes/I_Commandes/QueriesCommande.php';

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
    <link rel="stylesheet" href="../Styles/page_style.css">

    <script src="../Scripts/HandleNotifCompte.js" defer></script>
    <script src="../Scripts/HandleNotifSolde.js" defer></script>
    <!-- "defer" pour que le script s'éxécute après le chargement de l'html -->
    <script src="../Scripts/HandleDivRechargerSolde.js" defer></script>
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
            <a href="../Controllers/logoutCall.php" class="sidebar-btn navbar-btn">Déconnexion</a>
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
        <div class="page-content">
            <?php
            echo "Bienvenue, " . "<span style='font-weight:bold;'>" . htmlspecialchars($_SESSION['user']['prenom']) . "&nbsp;" . htmlspecialchars($_SESSION['user']['nom']) . "</span>";
            ?>
        </div>

        <div class="divider-horizontal"></div>
        <!-- <div class="divider-horizontal" style="margin-top: 0px !important;margin-bottom: 0px !important;"></div> -->
        
        <div id="messageSolde" class="notif-success">
            Solde bien rechargé ! <span><a href="../Controllers/logoutCall.php">Déconnectez-vous</a></span> puis reconnectez-vous pour voir les changements.
        </div>
        <div id="messageSoldeCharger" class="notif-success">
            Vous avez bien inséré votre premier montant sur votre compte. <span><a href="../Controllers/logoutCall.php">Déconnectez-vous</a></span> puis reconnectez-vous pour voir les changements.
        </div>

        <div class="solde-content">
            <?php
            echo "<span style='margin-left:10px;font-size:16px;'>Solde actuel : </span><br>";

            if (isset($_SESSION['user']['solde'])) {
                echo "<span style='margin-left: 10px;font-size:50px;'><b>" . htmlspecialchars($_SESSION['user']['solde']) . " € </b></span><br>";
            } else {
                echo "<span style='margin-left: 10px;font-size:50px;'><b>0 € </b></span><br>";
            }
            $soldeIsset = isset($_SESSION['user']['solde']);
            if (!$soldeIsset) {
                // bouton pour OUVRIR la div charger (type=button pour ne pas soumettre le form)
                echo '<button type="button" id="btnCharger" style="margin-left: 10px;" class="sidebar-btn">Charger</button>';
            } else {
                // bouton pour OUVRIR la div recharger (type=button)
                echo '<button type="button" id="btnRecharger" style="margin-left: 10px;" class="sidebar-btn">Recharger</button>';
            }
            ?>
        </div>
        
        <!-- Afficher cette div que si le bouton recharger est cliqué -->
        <div class="recharger-content" id="rechargerDiv" style="display:none;">

            <span style="color:#ff8800; margin-left: 10px;">Recharger le <b>solde</b></span>

            <div class="divider-horizontal" style="background: #ff8800 !important;margin-top: 5px !important;margin-bottom: 0px !important;"></div>

            <form method="post" style="margin-top: 10px;">
                <input type="hidden" name="action" 
                       value="<?php echo ($_SESSION['type'] === 'artiste') ? 'addSoldeToArtiste' : 'addSoldeToCompte'; ?>">

                <input type="hidden" name="id" value="<?php echo htmlspecialchars($_SESSION['user']['id']); ?>">

                <label><span style="font-size: 14px; margin-left:10px;">Montant :</span></label>
                <input type="text" name="amount" required><br>

                <button type="submit" style="margin-left: 10px;margin-top:5px; margin-bottom:5px;" class="sidebar-btn">Recharger</button>
            </form>
        </div>

        

        <!-- div Charger -->
        <div class="charger-content" id="chargerDiv" style="display:none;">
            <span style="color:#ff8800; margin-left: 10px;">Charger le <b>solde</b></span>
            <div class="divider-horizontal" style="background: #ff8800 !important;margin-top: 5px !important;margin-bottom: 0px !important;"></div>

            <form method="post" style="margin-top: 10px;">
                <input type="hidden" name="action" value="insertSolde">

                <input type="hidden" name="fkCompte" 
                       value="<?php echo ($_SESSION['type'] === 'compte') ? $_SESSION['user']['id'] : ''; ?>">

                <input type="hidden" name="fkArtiste" 
                       value="<?php echo ($_SESSION['type'] === 'artiste') ? $_SESSION['user']['id'] : ''; ?>">

                <input type="hidden" name="description" value="Recharge du solde">

                <label><span style="font-size: 14px; margin-left:10px;">Montant :</span></label>
                <input type="number" name="solde" required><br> <!-- IMPORTANT -->

                <button type="submit" style="margin-left: 10px;margin-top:5px; margin-bottom:5px;" class="sidebar-btn">
                    Charger
                </button>
            </form>
        </div>


        <?php if (isset($_SESSION['type']) && $_SESSION['type'] === 'artiste'): ?>
        <div class="solde-content-no-bg" style="display: flex; gap: 10px; margin-top: 20px;">
            <div style="flex: 1; border-radius: 8px; background-color: #efefef; padding: 10px;">
                <span style='margin-left:10px;font-size:14px;'><b>Commandes</b> à traiter</span><br>
                <?php
                $artisteId = $_SESSION['user']['id'];
                $commandes = getCommandeByArtisteID($artisteId);

                if (!empty($commandes)) {
                    foreach ($commandes as $commande) {
                        echo '<div style="
                            border: 1px solid #ccc;
                            border-radius: 8px;
                            padding: 10px;
                            margin-bottom: 10px;
                            background-color: #f9f9f9;
                        ">';

                        echo "<span style='font-weight:bold;color:#ff8800;'>Commande n°" . htmlspecialchars($commande['idNumCommande']) . "</span>&nbsp;";
                        echo "<span style='color:rgba(0,0,0,0.5);font-size:15px;'>" . htmlspecialchars($commande['dateCommande']) . "</span><br>";
                        echo "<span>Description : " . htmlspecialchars($commande['description']) . "</span><br>";
                        echo "<span>Prix : " . htmlspecialchars($commande['prix']) . " €</span><br>";
                        echo "<span>Statut : " . htmlspecialchars($commande['statut']) . "</span><br>";
                        echo "<span>Client : " . htmlspecialchars($commande['nomCompte']) . " (" . htmlspecialchars($commande['usernameCompte']) . ")</span>";

                        echo '</div>';
                    }
                } else {
                    echo '<div style="font-style: italic; color: #777;">Aucune commande trouvée.</div>';
                }
                ?>
            </div>
            <div style="flex: 1; border-radius: 8px; background-color: #efefef; padding: 10px;">
                <span>Div 2</span>
            </div>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>