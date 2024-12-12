<?php 

session_start();

if(isset($_SESSION['id'])){

    include('../../include/nav.php');

?>
    <title>ajouter Utilisateur</title>

    <div class="main">

        <section class="signup">
            <div class="container">

                 <div class="signup-content">
                
                    <div class="signup-form">
                        <h3 class="form-title">Ajouter admin  </h3>
                        <form method="POST" action="/php/ajouterUtilisateur.php" class="register-form" id="register-form">
                        <div class="form-group">
                                <label for="name"></label>
                                
                                <input class="nav-link disabled"  type="text" name="role"  value="admin" />
                               
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="nom"  placeholder=" nom"  />
                                
                            </div>
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="prenom"  placeholder=" prenom" />
                               
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder=" Email" />
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
                        <figure><img src="/images/signup-image.jpg" alt="sing up image"></figure>
                    </div>
                </div>
            </div>
        </section>

        <?php }else{

               header('location: /intrface/homeClient.php');
        }