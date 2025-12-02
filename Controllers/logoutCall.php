<?php
session_start();

// Détruire toutes les données de session
$_SESSION = [];
session_destroy();

// Rediriger vers la page de login
header("Location: ../Views/FourtherrLogin.php");
exit;
?>