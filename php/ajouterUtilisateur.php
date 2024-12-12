
<?php 
include('../include/connection.php');

$nom=$_POST['nom']?? '';
$prenom=$_POST['prenom']?? '';
$email=$_POST['email']?? '';
$password=$_POST['password']?? '';
$passwordCon =$_POST['passwordCon']?? '';
$role=$_POST['role'];
$errors=[
    
      'nomError'=>'',
      'prenomError'=>'',
      'emailError'=>'',
      'mdpError'=>'',
      'mdpConError'=>'',
      'valid'=>'',
      'nonvalid'=>''
  ];


  if(isset($_POST['submit'])){

$md5=md5($password);
$con='admin';
$error=false;


$check_email="SELECT * FROM `users` WHERE  email='$email' ";
     $check_result=mysqli_query($connection,$check_email);
     $rw=mysqli_num_rows($check_result);
     if($rw != 0){
        $errors['emailError']='l\'e-mail exsist déjà';
        $error=true;
     }
     if($role!=$con){
        echo 'le role n\'pas valid!!';
        $error=true;
     }
     if(empty($nom)){
        $errors['nomError']='entre votre nom svp';
        $error=true;
    }elseif (strlen($nom)<3){
        $errors['nomError']='le nom n\'pas valid';
        $error=true;
    } elseif (filter_var($nom,FILTER_VALIDATE_INT)){
        $errors['nomError']='le nom n\'pas valid';
        $error=true;
     }
       else if(empty($prenom)){
            $errors['prenomError']='entre votre prenom svp';
            $error=true;
          }elseif (strlen($prenom)<3){
            $errors['prenomError']='le prenom n\'pas valid';
            $error=true;
          }  elseif (filter_var($prenom,FILTER_VALIDATE_INT)){
            $errors['prenomError']='le prenom n\'pas valid';
            $error=true;
          } 
    
         
      elseif(empty($email)){
        $errors['emailError']='entre l email svp ';
        $error=true;
      }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['emailError']='l\'e-mail n\'pas valid';
        $error=true;
       
      }

     else if(empty($password)){
        $errors['mdpError']='entre le mote de passe svp';
        $error=true;
         }else if(strlen($password)<6){
              $errors['mdpError']='le mote de passe n\'pas valid';
              $error=true;
         }

       else  if(empty($passwordCon)){
            $errors['mdpConError']='entrer la confirmation de mote de passe svp ';
            $error=true;
         }elseif($passwordCon!=$password){
            $errors['mdpConError']='s\'pas le meme mote de passe  ';
            $error=true;
         }

         if(($error==false)&&($rw == 0)){
$sql="INSERT INTO `users`(`nom`,`prenom`,`email`,`password`,`role`)  VALUES ('$nom','$prenom','$email','$md5','$role') ";

      if(mysqli_query($connection,$sql)) {

        header('location: ../intrface/admin/Utilisateurs.php');

      }


         }else{
          
               ?> 
               <div class="alert alert-danger" role="alert">
                 
               le compte n'pas enregestre!! <br>
               <?php echo $errors['nomError']; ?><br>
               <?php echo $errors['prenomError']; ?><br>
               <?php echo $errors['emailError']; ?><br>
               <?php echo $errors['mdpError']; ?><br>
               <?php echo $errors['mdpConError']; ?><br>
</div>   
      <a href="/intrface/admin/ajouterUtilisateur.php">back</a>
        <?php  
                
    }
        }
?>