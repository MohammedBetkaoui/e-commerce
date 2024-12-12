<?php 
session_start();
include('../include/connection.php');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : '../intrface/homeClient.php'; // URL de redirection par défaut

$errors = '';
$error = false;

if (isset($_POST['submit'])) {
    $md5 = md5($password);

    if (empty($email)) {
        $errors = 'Entrez votre email, svp.';
        $error = true;
    } elseif (empty($password)) {
        $errors = 'Entrez votre mot de passe, svp.';
        $error = true;
    }

    if (!$error) {
        $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$md5'";
        $resultat = mysqli_query($connection, $sql);

        if (mysqli_num_rows($resultat) > 0) {
            $table = mysqli_fetch_assoc($resultat);

            if ($table['password'] == $md5 && $table['email'] == $email) {
                $block = "SELECT * FROM `block` WHERE `email_user`='$email'";
                $res = mysqli_query($connection, $block);

                if (mysqli_num_rows($res) == 0) {
                    if ($table['role'] == 'Admin') {
                        $_SESSION['id'] = $table['id'];
                        $_SESSION['prenom'] = $table['prenom'];
                        $_SESSION['nom'] = $table['nom'];
                        $_SESSION['email'] = $table['email'];
                        header('location: ../../../intrface/admin/home.php');
                    } elseif ($table['role'] == 'admin') {
                        $_SESSION['id_a'] = $table['id'];
                        $_SESSION['prenom_a'] = $table['prenom'];
                        $_SESSION['nom_a'] = $table['nom'];
                        $_SESSION['email_a'] = $table['email'];
                        header('location: ../../../intrface/admin/home.php');
                    } elseif ($table['role'] == 'client') {
                        $_SESSION['id_c'] = $table['id'];
                        $_SESSION['prenom_c'] = $table['prenom'];
                        $_SESSION['nom_c'] = $table['nom'];
                        $_SESSION['email_c'] = $table['email'];
                        $_SESSION['tlf_c'] = $table['tlf'];
                        header("Location: $redirectUrl");
                    }
                } else {
                    header('location:../intrface/compteBloque.php');
                }
                exit();
            }
        } else {
            $error = true;
            $errors = 'Vérifiez vos informations.';
        }
    }
}
?>
