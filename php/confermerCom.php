<?php 
include('../include/connection.php');

$id = $_GET['id'];

$status = 1;

$sql = "UPDATE `commandes` SET `status`='$status' WHERE `id` = $id ";

      mysqli_query($connection,$sql);

      header('location: ../../../intrface/admin/commende.php');

?>
