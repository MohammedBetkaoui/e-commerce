<?php 
$connection=mysqli_connect('localhost','root','','db');
if (!$connection) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
}
?>