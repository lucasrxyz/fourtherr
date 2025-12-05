<?php
require_once __DIR__ . '../../../Requetes/T_Portofolio/QueriesPortofolio.php';

session_start();

// Protection de la page
if (!isset($_SESSION['user'])) {
    header("Location: ../FourtherrLogin.php");
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
    <link rel="stylesheet" href="../../Styles/rootCss.css">
    <link rel="stylesheet" href="../../Styles/Decouvrir/images.css">
    <link rel="stylesheet" href="../../Styles/Decouvrir/portofolioGlobal.css">

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

        <div class="divider-horizontal"></div>
        
        <div class="solde-content-no-bg" style="display: flex; gap: 10px; margin-top: 20px;">
            <div style="flex: 1; border-radius: 8px; background-color: #efefef; padding: 10px;">
                <?php
                $raw = getAllPortofolio();

                // Regroupement des portfolios
                $portfolios = [];

                foreach ($raw as $row) {
                    $id = $row['id'];
                
                    // Si le portfolio n'existe pas encore, on le crée
                    if (!isset($portfolios[$id])) {
                        $portfolios[$id] = [
                            "id"            => $row["id"],
                            "titre"         => $row["titre"],
                            "description"   => $row["description"],
                            "image"         => $row["image"],
                            "DateCreation"  => $row["DateCreation"] ?? null,
                            "FK_idArtiste"  => $row["FK_idArtiste"],
                            "nom"           => $row["nom"],
                            "prenom"        => $row["prenom"],
                            "username"      => $row["username"],
                            "images"        => [],   // liste des images liées depuis la table l_portofolioimages
                            "filters"       => []   // liste des filters liés depuis la table l_portofoliofilters
                        ];
                    }
                
                    // Ajouter l'image uniquement si elle n'existe pas déjà
                    if (!empty($row["linkPic"]) && !in_array($row["linkPic"], $portfolios[$id]["images"])) {
                        $portfolios[$id]["images"][] = $row["linkPic"];
                    }

                    // Ajouter le filter uniquement si pas déjà ajouté
                    if (!empty($row["filter"]) && !in_array($row["filter"], $portfolios[$id]["filters"])) {
                        $portfolios[$id]["filters"][] = $row["filter"];
                    }
                }

                if (!empty($portfolios)) {
                    foreach ($portfolios as $portofolios) {
                    
                        echo '<div style="
                            border: 1px solid #ff8800;
                            border-radius: 8px;
                            padding: 10px;
                            margin-bottom: 10px;
                            background-color: #faf8f5;
                        ">';
                    
                        echo "<span class='fs-18 ma-0 pa-0' style='color: #ff8800'><b>" 
                             . htmlspecialchars($portofolios['titre']) . "</b></span>";
                    
                        $dt = DateTime::createFromFormat("Y-m-d H:i:s", $portofolios['DateCreation']);
                        $formattedDate = $dt ? $dt->format("M. dS, Y - H\hi") : $portofolios['DateCreation'];
                    
                        echo "<span class='fs-14' style='margin-left:15px;opacity:50%;'>" 
                             . htmlspecialchars($formattedDate) . "</span>";
                    
                        echo "<div class='divider-horizontal' style='background: rgba(180, 96, 0, 1) !important;margin-top: 5px !important;margin-bottom: 0px !important;'></div><br>";
                        
                        echo "&nbsp;<span class='artiste'>" . htmlspecialchars($portofolios['prenom']) . "&nbsp;<b>" . htmlspecialchars($portofolios['nom']) . "</b></span>";
                        
                        echo "<div class='divider-horizontal' style='background: rgba(180, 96, 0, 1) !important;margin-top: 5px !important;margin-bottom: 0px !important;'></div><br>";

                        // Affichage des images du portfolio
                        if (!empty($portofolios["images"])) {
                        
                            echo "<div class='portfolio-images'>";
                        
                            foreach ($portofolios["images"] as $imgUrl) {
                                if (preg_match('/\.(jpg|jpeg|png|gif|webp)(\?.*)?$/i', $imgUrl)) {
                                
                                    echo "<div class='img-169-container'>
                                            <img src='" . htmlspecialchars($imgUrl) . "' alt='image portfolio'>
                                          </div>";
                                }
                            }
                        
                            echo "</div>";
                        
                        } else {
                            echo "<div style='font-style: italic; color: #777;'>Aucune image</div>";
                        }

                        if (!empty($portofolios["filters"])) {

                            echo "<br>";

                            foreach ($portofolios["filters"] as $filterPortofolio) {
                                echo "<span class='filter-portofolio'>" . htmlspecialchars($filterPortofolio) . "</span>";
                            }
                        }
                        echo '</div>';
                    }
                
                } else {
                    echo '<div style="font-style: italic; color: #777;">Aucun portofolio trouvé.</div>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>