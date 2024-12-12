<?php 

session_start();

include('../include/connection.php');

if($_SESSION){

  header('location: ../intrface/index.php');
}


$id=$_POST['id'];
$qun=$_POST['quantité'];

$id_c=$_SESSION['id_c'];

if(!isset($_SESSION['panier'][$id_c])){
   
  $_SESSION['panier'][$id_c]=[];
}
$_SESSION['panier'][$id_c][$id]=$qun;

header('location: ../intrface/panier.php');
  
