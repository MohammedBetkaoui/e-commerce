<?php 

include('../include/connection.php');




    $id = $_GET['id'];
    
    $sql="DELETE FROM `categorie` WHERE `categorie`.`id`=$id";
     
      if(mysqli_query($connection,$sql)){

            header('location:../../../intrface/admin/categories.php');
      }else{
        echo 'error';
      }
