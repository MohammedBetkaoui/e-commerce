<?php 
include('../include/connection.php');

$id_c = $_GET['id_c'];
$id_p = $_GET['id_p'];

$sql="DELETE FROM `commandes` WHERE `id_produit`=$id_p AND `id_user`=$id_c";
 
    mysqli_query($connection,$sql);

    header('location: ../../../intrface/panier.php ');
 