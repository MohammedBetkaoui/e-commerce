<?php 
include('../include/connection.php');

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id_commande = $_GET['id'];
    $new_status = $_GET['status'];

    $sql = "UPDATE `commende` SET `status` = '$new_status' WHERE `id` = '$id_commande'";

    if (mysqli_query($connection, $sql)) {
        echo "<script>
                alert('Statut mis à jour avec succès!');
                window.location.href = '../intrface/admin/commende.php';
              </script>";
    } else {
        echo "<script>
                alert('Erreur lors de la mise à jour du statut!');
                window.history.back();
              </script>";
    }
} else {
    header('location: ../../../intrface/admin/home.php');
}
?>
