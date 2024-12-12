<?php include('../php/inscription.php')  ?>

<?php 

session_start();

if(isset($_SESSION['id_c'])){

    header('location: /intrface/homeClient.php');
}else {

include('../include/nav.php')
?>
<title>inscription</title>

    <div class="main">
        <section class="signup">
            <div class="container">

                 <div class="signup-content">
                
                    <div class="signup-form">
                        <h3 class="form-title">créer un compte</h3>
                        <?php if($error==true){?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo $errors?></div>
                        <?php } ?>

                        <form method="POST" action="../intrface/inscription.php" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="nom"  placeholder="Votre nom" value="<?php echo $nom ?>"  />
                                
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="prenom"  placeholder="Votre prenom" value="<?php echo $prenom ?>"/>
                               
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Votre Email"value="<?php echo $email ?>" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="number" name="tlf" id="email" placeholder="Votre numéro de téléphone"value="<?php echo $tlf ?>" />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Mot de passe" />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="passwordCon" id="re_pass" placeholder="Confirmation de Mot de passe "/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="signup" class="form-submit" value="sauvegarder"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="../images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="index.php" class="signup-image-link">je suis déjà membre</a>
                    </div>
                </div>
            </div>
        </section>

        <?php }?>