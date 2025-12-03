<?php
session_start();

// Protection de la page
if (!isset($_SESSION['user'])) {
    header("Location: FourtherrLogin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Fourtherr</title>
    <link rel="stylesheet" href="../Styles/page_style.css">
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <strong>FOURTHERR</strong>

        <div class="navbar-right">
            <pre style="color:white;">
                <?php 
                echo htmlspecialchars($_SESSION['user']['prenom']); 
                echo "&nbsp;"; 
                echo htmlspecialchars($_SESSION['user']['nom']); 
                ?>
            </pre>
            <a href="solde.php" class="sidebar-btn navbar-btn">Solde</a>
            <a href="../Controllers/logoutCall.php" class="sidebar-btn navbar-btn">Déconnexion</a>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">

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

        <!-- Artistes -->
        <div class="sidebar-group">
            <div class="sidebar-group-title">Artistes</div>

            <div class="sidebar-item">
                <a href="#" class="sidebar-btn">Mon Portofolio</a>
            </div>

            <div class="sidebar-item">
                <a href="#" class="sidebar-btn">Découvrir</a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="page-content">
            <?php
            echo "Bienvenue, " . "<span style='font-weight:bold;'>" . htmlspecialchars($_SESSION['user']['prenom']) . "</span>";
            ?>
        </div>
        
        <div class="divider-horizontal">
        </div>

        <div class="solde-content">
            <?php
            echo "<span style='margin-left:10px;font-size:16px;'>Solde actuel : </span><br>";

            if (isset($_SESSION['user']['solde'])) {
                echo "<span style='margin-left: 10px;font-size:50px;'><b>" . htmlspecialchars($_SESSION['user']['solde']) . " € </b></span><br>";
            } else {
                echo "<span style='margin-left: 10px;font-size:50px;'><b>0 € </b></span><br>";
            }
            ?>
            <?php 
            $soldeIsset = isset($_SESSION['user']['solde']);

            if (!$soldeIsset) {
                echo '<button type="button" style="margin-left: 10px;" class="sidebar-btn">Charger</button>';
            }
            else {
                 echo '<button type="button" style="margin-left: 10px;" class="sidebar-btn">Recharger</button>';
            }
            ?>

        </div>
    </div>

</body>
</html>
