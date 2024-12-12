<?php
// Récupérer le message d'erreur passé en paramètre
$error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : 'Une erreur inconnue s\'est produite.';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f7f7f7;
        }
        .error-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .error-container h1 {
            font-size: 2.5em;
            color: #e74c3c;
        }
        .error-container p {
            font-size: 1.2em;
            color: #555;
        }
        .error-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .error-container a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Erreur</h1>
        <p><?= $error_message ?></p>
        <a href="index.php">Retour à l'accueil</a>
    </div>
</body>
</html>
