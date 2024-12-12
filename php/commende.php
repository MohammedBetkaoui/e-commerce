<?php 
include('../include/connection.php');

// Vérifier si une commande globale a été passée
if ($_POST && isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];
    $date_actuelle = date("Y-m-d H:i:s");

    // Récupérer le panier de l'utilisateur
    $panier = $_SESSION['panier'][$id_user];

    // Ajouter chaque produit dans la table `commende`
    foreach ($panier as $id_produit => $quantite) {
        if ($id_produit != 0) {
            // Récupérer le prix du produit
            $sql_produit = "SELECT prix FROM `produits` WHERE id = '$id_produit'";
            $result_produit = mysqli_query($connection, $sql_produit);
            $produit = mysqli_fetch_assoc($result_produit);
            $total = $produit['prix'] * $quantite;

            // Insérer dans la table des commandes
            $sql_commande = "INSERT INTO `commende` (`id_user`, `id_produit`, `quantité`, `prix_total`, `date`) 
                            VALUES ('$id_user', '$id_produit', '$quantite', '$total', '$date_actuelle')";
            mysqli_query($connection, $sql_commande);
        }
    }

    // Vider le panier après commande
    unset($_SESSION['panier'][$id_user]);

    // Redirection après la commande
    header('Location: ../intrface/panier.php?success=true');
    exit;
}

// Si une commande individuelle est passée
if ($_GET) {
    $id = $_GET['id'];
    $id_p = $_GET['id_p'];
    $qun = $_GET['qun'];
    $total = $_GET['total'];
    $date_actuelle = date("Y-m-d H:i:s");

    $sql = "INSERT INTO `commandes` (`id_user`, `id_produit`, `quantité`, `prix_total`, `date`) 
            VALUES ('$id', '$id_p', '$qun', '$total', '$date_actuelle')";
    $res = mysqli_query($connection, $sql);

    // Redirection après la commande
    header('Location: ../intrface/panier.php?success=true');
    exit;
}
?>
