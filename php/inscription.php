
    <?php 

include('../include/connection.php');

$nom=$_POST['nom']?? '';
$prenom=$_POST['prenom']?? '';
$email=$_POST['email']?? '';
$password=$_POST['password']?? '';
$passwordCon =$_POST['passwordCon']?? '';
$tlf =$_POST['tlf']?? '';
$errors='';
    
      
$error=false;

  if(isset($_POST['submit'])){

$md5=md5($password);



$check_email="SELECT * FROM `users` WHERE  email='$email' ";
     $check_result=mysqli_query($connection,$check_email);
     $rw=mysqli_num_rows($check_result);
     if($rw != 0){
        $errors='l\'e-mail exsist déjà';
        $error=true;
     }

     if(empty($nom)){
        $errors='entre votre nom svp';
        $error=true;
    }elseif (strlen($nom)<3){
        $errors='le nom n\'pas valid';
        $error=true;
    } elseif (filter_var($nom,FILTER_VALIDATE_INT)){
        $errors='le nom n\'pas valid';
        $error=true;
     }
       else if(empty($prenom)){
            $errors='entre votre prenom svp';
            $error=true;
          }elseif (strlen($prenom)<3){
            $errors='le prenom n\'pas valid';
            $error=true;
          }  elseif (filter_var($prenom,FILTER_VALIDATE_INT)){
            $errors='le prenom n\'pas valid';
            $error=true;
          } 
    
         
      elseif(empty($email)){
        $errors='entre l email svp ';
        $error=true;
      }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors='l\'e-mail n\'pas valid';
        $error=true;
       
      }elseif(empty($tlf)){
        $errors='entre votre numéro de téléphone svp';
        $error=true;
    
         }elseif(strlen($tlf)>10){
          $errors=' le numéro de téléphone n\'pas valid ';
          $error=true;
         }
         elseif(strlen($tlf)<10){
          $errors=' le numéro de téléphone n\'pas valid ';
          $error=true;
         }

     else if(empty($password)){
        $errors='entre le mote de passe svp';
        $error=true;
         }else if(strlen($password)<6){
              $errors='le mote de passe n\'pas valid';
              $error=true;
         }

       else  if(empty($passwordCon)){
            $errors='entrer la confirmation de mote de passe svp ';
            $error=true;
         }elseif($passwordCon!=$password){
            $errors='ce n\'est pas le même mot de passe  ';
            $error=true;
         }

         if(($error==false)&&($rw == 0)){
$sql="INSERT INTO `users`(`nom`,`prenom`,`email`,`tlf`,`password`)  VALUES ('$nom','$prenom','$email','$tlf','$md5') ";

       mysqli_query($connection,$sql);
         
       header('location: ../intrface/index.php');
         
                
    }
        }
?>