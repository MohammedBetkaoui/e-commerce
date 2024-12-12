<?php
include('../php/index.php');

if(isset($_SESSION['id_c'])||isset($_SESSION['id']) || isset($_SESSION['id_a']) ){

    header('location: /intrface/homeClient.php');
}else {

include('../include/nav.php');

?>
    <title>Se connecter</title>

<section>
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="../images/signin-image.jpg" alt="sing up image"></figure>
                       
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Se connecter </h2>
                        <?php if($error==true){?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errors ;?></div>
                           <?php } ?>

                        <form method="POST" action="/intrface/index.php" class="register-form" id="login-form">
                           <div></div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" value="<?php echo $email ?>" placeholder="Votre Email"/>
                                
                            </div>
                            <div></div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="your_pass" placeholder="Votre Mot de passe"/>
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="signin" class="form-submit" value="se connecter"/>
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label"> <a href="inscription.php" class="signup-image-link">Créer un compte</a></span>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
    </div> 
</body>
</html>

<?php }?>