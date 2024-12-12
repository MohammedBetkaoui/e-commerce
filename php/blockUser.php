<?php 

include('../include/connection.php');

$id = $_GET['id'];

$sql_1="SELECT * FROM `users` WHERE `id`='$id'";

$res=mysqli_query($connection,$sql_1);

$tab=mysqli_fetch_assoc($res);

$email=$tab['email'];

$sql_2="INSERT INTO `block` (`email_user`)  VALUE ('$email')";  

if(mysqli_query($connection,$sql_2)){
     
    header('location:../../../intrface/admin/Utilisateurs.php');

}else{
    echo 'error';
}
