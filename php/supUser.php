<?php 


include('../include/connection.php');




     $id = $_GET['id'];

     

    $sql="DELETE FROM `users` WHERE `id`=$id";
     
      if(mysqli_query($connection,$sql)){

            header('location: ../../../intrface/admin/Utilisateurs.php');
      }else{
        echo 'error';
      }


           