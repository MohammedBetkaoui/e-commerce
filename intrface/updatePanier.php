<?php
session_start();
$id = $_POST['id'];
$quantity = $_POST['quantity'];

if (isset($_SESSION['panier'][$_SESSION['id_c']][$id])) {
    $_SESSION['panier'][$_SESSION['id_c']][$id] = $quantity;
    echo 'success';
}
?>
