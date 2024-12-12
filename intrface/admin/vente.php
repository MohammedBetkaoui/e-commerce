<?php
include('../../include/nav.php'); // Navigation

if (isset($_SESSION['id']) || isset($_SESSION['id_a'])) {
    // Chemin vers le script Python
    $pythonScript = escapeshellcmd('../../scripts/analyse_ventes.py');

    // Appeler le script Python
    $output = shell_exec("python $pythonScript");

    // Décoder la sortie JSON
    $data = json_decode($output, true);

    // Gestion des erreurs si JSON invalide
    if (!$data || isset($data['error'])) {
        $errorMsg = $data['error'] ?? "Erreur lors de la récupération des données.";
        die("<h3>$errorMsg</h3>");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse des Ventes</title>
    <link rel="stylesheet" href="../../styles/style.css"> <!-- Lien CSS -->
</head>
<body>
    <h1>Analyse des Ventes par Produit</h1>
    <div id="chart_div"></div>

    <!-- Tableau des Produits -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité Vendue</th>
                <th>Ventes Totales (Dz)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom_produit']) ?></td>
                    <td><?= htmlspecialchars($row['total_quantite']) ?></td>
                    <td><?= htmlspecialchars(number_format($row['total_ventes'], 2)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<?php
} else {
    header('location: ../index.php'); // Redirection si l'utilisateur n'est pas connecté
}
?>
