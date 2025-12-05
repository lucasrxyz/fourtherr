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

        case 'getAllIDOnly':
            $result = getAllIDOnlyPortofolio();
            break;
        
        case 'getByID':
            $idPortofolio = $_POST['idPortofolio'] ?? 0;
            $result = getAllPortofolioByID($idPortofolio);
            break;

        case 'getAllPortofolioArtiste':
            $idArtiste = $_POST['idArtiste'] ?? 0;
            $result = getPortofolioArtiste($idArtiste);
            break;

        case 'createPortofolio':
            $titre = $_POST['titre'] ?? 0;
            $description = $_POST['description'] ?? 0;
            $imageLink = $_POST['imageLink'] ?? 0;
            $idArtiste = $_POST['idArtiste'] ?? 0;
            $result = createNewPortofolio($titre, $description, $imageLink, $idArtiste);
            break;

        case 'setImagePortofolio':
            $link = $_POST['link'] ?? 0;
            $idPortofolio = $_POST['idPortofolio'] ?? 0;
            $result = setImageToPortofolio($link, $idPortofolio);
            break;
        
        case 'setFilterPortofolio':
            $filter = $_POST['filter'] ?? 0;
            $idPortofolio = $_POST['idPortofolio'] ?? 0;
            $result = setFilterToPortofolio($filter, $idPortofolio);
            break;
        
        case 'deletePortofolio':
            $idPortofolio = $_POST['idPortofolio'] ?? 0;
            $result = deletePortofolio($idPortofolio);
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Queries Portofolio</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        input, select { margin: 5px 0; }
        pre { background: #f4f4f4; padding: 10px; }
    </style>
</head>
<body>

<h1>TABLE <span style="color:#0000FE;font-weight:bold;">T_PORTOFOLIO</span></h1>

<!-- Tous les formulaires -->

<form method="post">
    <b>getAllPortofolio()</b><br>
    <input type="hidden" name="action" value="getAll">
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <b>getAllIDOnlyPortofolio()</b><br>
    <input type="hidden" name="action" value="getAllIDOnly">
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <b>getAllPortofolioByID($idPortofolio)</b><br>
    <input type="hidden" name="action" value="getByID">
    <label>ID Portofolio :</label>
    <input type="number" name="idPortofolio" required><br>
    <button type="submit">Éxécuter</button>
</form>

<form method="post">
    <b>getPortofolioArtiste($idArtiste)</b><br>
    <input type="hidden" name="action" value="getAllPortofolioArtiste">
    <label>ID Artiste :</label>
    <input type="number" name="idArtiste" required><br>
    <button type="submit">Éxécuter</button> 
</form>

<form method="post">
    <b>createNewPortofolio($titre, $description, $imageLink, $idArtiste)</b><br>
    <input type="hidden" name="action" value="createPortofolio">

    <label>Titre :</label>
    <input type="text" name="titre" required><br>
    <label>Description :</label>
    <input type="text" name="description" required><br>
    <label>Lien image :</label>
    <input type="text" name="imageLink" required><br>
    <label>ID Artiste :</label>
    <input type="number" name="idArtiste" required><br>

    <button type="submit">Éxécuter</button> 
</form>

<form method="post">
    <b>setImageToPortofolio($link, $idPortofolio)</b><br>
    <input type="hidden" name="action" value="setImagePortofolio">

    <label>Lien :</label>
    <input type="text" name="link" required><br>
    <label>ID Portofolio :</label>
    <input type="text" name="idPortofolio" required><br>

    <button type="submit">Éxécuter</button> 
</form>

<form method="post">
    <b>setFilterToPortofolio($filter, $idPortofolio)</b><br>
    <input type="hidden" name="action" value="setFilterPortofolio">

    <label>Filter :</label>
    <input type="text" name="filter" required><br>
    <label>ID Portofolio :</label>
    <input type="text" name="idPortofolio" required><br>

    <button type="submit">Éxécuter</button> 
</form>

<form method="post">
    <b>deletePortofolio($idPortofolio)</b><br>
    <input type="hidden" name="action" value="deletePortofolio">
    
    <label>ID Portofolio :</label>
    <input type="text" name="idPortofolio" required><br>

    <button type="submit">Éxécuter</button> 
</form>

<!-- Résultat -->
<?php if ($result !== null): ?>
    <h3><span style="color:#0000FE"><b>JSON</b></span> response body</h3>
    <pre><?php echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?></pre>
<?php endif; ?>

</body>
</html>
