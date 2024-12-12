<?php 

include('../include/connection.php');




    $id = $_GET['id'];
    
    $sql="DELETE FROM `produits` WHERE `id`=$id";
     
      if(mysqli_query($connection,$sql)){

            header('location:../../../intrface/admin/produits.php');
      }else{
        echo 'error';
      }
