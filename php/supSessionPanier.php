<?php 

session_start();

include('../include/connection.php');

$id_c=$_SESSION['id_c'];
$id_p=$_GET['id_p'];
unset($_SESSION['panier'][$id_c][$id_p]);

header('location: ../../../intrface/panier.php ');

