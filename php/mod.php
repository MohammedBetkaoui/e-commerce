<?php
session_start();
include('../include/connection.php');
include('../include/nav.php');

// Vérification de la session
if (!isset($_SESSION['id'])) {
    header('Location: ../../index.php');
    exit();
}

// Validation de l'ID produit
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('<p>ID de produit invalide.</p>');
}

// Récupération du produit depuis la base de données
$query = "SELECT * FROM `produits` WHERE `id` = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produit = $result->fetch_assoc();

if (!$produit) {
    die('<p>Produit introuvable.</p>');
}

// Variables pour les valeurs par défaut du formulaire
$nomP = $produit['nom_produit'] ?? '';
$prix = $produit['prix'] ?? '';
$catigorie = $produit['id_categorie'] ?? '';
$description = $produit['description'] ?? '';
$image_url = $produit['image_url'] ?? '';

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomP = htmlspecialchars($_POST['nomP'] ?? '');
    $prix = htmlspecialchars($_POST['prix'] ?? '');
    $catigorie = htmlspecialchars($_POST['catigorie'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');
    $imagename = $image_url; // Par défaut, on garde l'image existante.

    // Gestion de l'upload de fichier
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $imagename = uniqid() . "_" . $image;

        // Vérification et déplacement du fichier
        if (!move_uploaded_file($tmp_name, "../images/produit/" . $imagename)) {
            die('<p>Échec du téléchargement de l\'image.</p>');
        }
    }

    // Mise à jour du produit dans la base de données
    $updateQuery = "UPDATE `produits` 
                    SET `nom_produit` = ?, 
                        `prix` = ?, 
                        `description` = ?, 
                        `id_categorie` = ?, 
                        `image_url` = ? 
                    WHERE `id` = ?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param("sdsisi", $nomP, $prix, $description, $catigorie, $imagename, $id);

    if ($stmt->execute()) {
        header('Location: ../../../intrface/admin/produits.php?success=1');
        exit();
    } else {
        die('<p>Erreur lors de la mise à jour du produit.</p>');
    }
}

// Récupération des catégories pour le menu déroulant
$categoryQuery = "SELECT * FROM `categorie`";
$categories = $connection->query($categoryQuery);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <style>
        /* Améliorer le style du formulaire */
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #343a40;
            border-radius: 8px;
        }

        h1 {
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Champs de formulaire */
        .form-control {
            background-color: #495057;
            border: 1px solid #6c757d;
            color: white;
        }

        .form-control:focus {
            background-color: #343a40;
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5);
        }

        /* Bouton de soumission */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Labels et texte */
        .form-label {
            color: #fff;
        }

        /* Image */
        .img-thumbnail {
            width: 150px;
            margin-top: 10px;
        }

        textarea {
            resize: vertical;
        }

    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Modifier le produit</h1>
        <form method="post" enctype="multipart/form-data" id="modifyProductForm">
            <!-- Nom du produit -->
            <div class="form-group mb-3">
                <input type="text" class="form-control" id="nomP" name="nomP" value="<?= htmlspecialchars($nomP) ?>" required>
            </div>

            <!-- Catégorie -->
            <div class="form-group mb-3">
                <select name="catigorie" class="form-select" id="catigorie" required>
                    <option value="">Choisissez une catégorie</option>
                    <?php while ($categorie = $categories->fetch_assoc()): ?>
                        <option value="<?= $categorie['id'] ?>" <?= $categorie['id'] == $catigorie ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie['nom']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Image -->
            <div class="form-group mb-3">
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                <?php if ($image_url): ?>
                    <img src="/images/produit/<?= htmlspecialchars($image_url) ?>" alt="Image actuelle" class="img-thumbnail">
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <textarea name="description" class="form-control" id="description" placeholder="Description" required><?= htmlspecialchars($description) ?></textarea>
            </div>

            <!-- Prix -->
            <div class="form-group mb-3">
                <input type="number" class="form-control" name="prix" id="prix" placeholder="Prix (dz)" required min="0" step="0.01" value="<?= htmlspecialchars($prix) ?>">
            </div>

            <!-- Bouton de soumission -->
            <div class="form-group mb-3">
                <button class="btn btn-success w-100" type="submit" name="submit" onclick="return confirmModification()">Modifier Produit</button>
            </div>
        </form>
    </div>

    <script>
        function confirmModification() {
            var nomProduit = document.getElementById("nomP").value;
            return window.confirm("Voulez-vous vraiment modifier le produit : " + nomProduit + " ?");
        }
    </script>

</body>

</html>
