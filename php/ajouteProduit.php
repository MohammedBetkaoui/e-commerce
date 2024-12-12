<?php
include('../include/connection.php');

$nomP = $_POST['nomP'] ?? '';
$prix = $_POST['prix'] ?? '';
$categorie = $_POST['catigorie'] ?? '';
$description = $_POST['description'] ?? '';
$date_created = date('Y-m-d H:i:s');
$quantité = $_POST['quantité'] ?? 1;

if (isset($_POST['submit'])) {
    // Insérer les données principales dans la table `produits`
    $sql = "INSERT INTO produits (nom_produit, id_categorie, description, prix, date_created, quantité) 
            VALUES ('$nomP', '$categorie', '$description', '$prix', '$date_created', '$quantité')";

    if (mysqli_query($connection, $sql)) {
        $produit_id = mysqli_insert_id($connection); // Récupérer l'ID du produit inséré

        // Gestion des images
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $key => $imageName) {
                $imageTemp = $_FILES['images']['tmp_name'][$key];
                $uniqueName = uniqid() . $imageName;

                if (move_uploaded_file($imageTemp, "../images/produit/" . $uniqueName)) {
                    // Insérer chaque image dans la table `produit_images`
                    $sqlImage = "INSERT INTO produit_images (produit_id, image_url) 
                                 VALUES ('$produit_id', '$uniqueName')";
                    mysqli_query($connection, $sqlImage);
                }
            }
        }

        header('location: ../../../intrface/admin/produits.php');
    } else {
        echo "Erreur : " . mysqli_error($connection);
    }
}
?>
