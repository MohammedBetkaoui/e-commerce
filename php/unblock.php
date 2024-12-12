<?php 

include('../include/connection.php');


    $email = $_GET['email'];
    
    $sql="DELETE FROM `block` WHERE `block`.`email_user`='$email'";
     
      if(mysqli_query($connection,$sql)){

            header('location:../../../intrface/admin/CompteBlock.php');
      }else{
        echo 'error';
      }