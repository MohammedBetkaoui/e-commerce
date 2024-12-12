<?php
session_start();
$id = $_POST['id'];

if (isset($_SESSION['panier'][$_SESSION['id_c']][$id])) {
    unset($_SESSION['panier'][$_SESSION['id_c']][$id]);
    echo 'success';
}
?>
