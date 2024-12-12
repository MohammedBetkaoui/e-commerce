<?php 

include('../../include/connection.php');




    $id = $_GET['id'];
    
    $sql="DELETE FROM `commende` WHERE `id`=$id";
     
      if(mysqli_query($connection,$sql)){

            header('location:../../../intrface/admin/commende.php');
      }else{
        echo 'error';
      }
