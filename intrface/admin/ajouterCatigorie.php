<?php
session_start();
include('../../include/connection.php');
include('../../include/nav.php');

echo '<title>Ajouter Catégorie</title>';
echo '<br><br>';

$nomCategorie = $_POST['nom'] ?? '';

if ($_SESSION['id']) {
    if (isset($_POST['submit'])) {
        // Vérification si la catégorie existe déjà
        $check_categorie = "SELECT * FROM `categorie` WHERE nom='$nomCategorie'";
        $check_result = mysqli_query($connection, $check_categorie);
        $rw = mysqli_num_rows($check_result);

        if ($rw != 0) {
            $error_message = "Cette catégorie existe déjà.";
        } else {
            // Ajout de la catégorie
            $query = "INSERT INTO `categorie`(`nom`) VALUES ('$nomCategorie')";
            if (mysqli_query($connection, $query)) {
                header('location: ./categories.php');
                exit();
            } else {
                $error_message = "Une erreur s'est produite lors de l'ajout de la catégorie.";
            }
        }
    }
    ?>

    <!-- Formulaire d'ajout de catégorie -->
    <div class="container">
        <h2 class="text-center">Ajouter une catégorie</h2><br>
        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <input type="text" class="form-control" id="categoryName" name="nom" placeholder="Nom de catégorie" required>
            </div><br>
            <input type="submit" class="btn btn-primary" value="Ajouter" name="submit">
        </form>
    </div>

    <?php
} else {
    header('location: ../index.php');
    exit();
}
?>
