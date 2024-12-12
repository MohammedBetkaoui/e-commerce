<?php
// Inclure la connexion uniquement si la page actuelle est categorie.php
if (basename($_SERVER['PHP_SELF']) == 'categorie.php') {
    include('../include/connection.php');
include('../include/navClient.php');
include('../include/debut.php');
    $cat = "SELECT * FROM `categorie`";
    $res = mysqli_query($connection, $cat);
?>
    <section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Nos Catégories</h2>
            <main>
                <ul class="categories">
                    <?php foreach($res as $cat){ ?>
                    <li class="category">
                        <a href="/intrface/prdouitsParCat.php?id=<?php echo $cat['id'] ?>&nom_cat=<?php echo $cat['nom'] ?>">
                            <?php echo $cat['nom'] ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </main>
        </div>
    </div>
</section>

<?php include('../include/fin.php'); } ?>

<?php  if (basename($_SERVER['PHP_SELF']) == 'homeClient.php') {

    // Exécuter la requête pour récupérer les catégories
    $cat = "SELECT * FROM `categorie`";
    $res = mysqli_query($connection, $cat);

    // Inclure la barre de navigation
?> 

  
<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Nos Catégories</h2>
            <main>
                <ul class="categories">
                    <?php foreach($res as $cat){ ?>
                    <li class="category">
                        <a href="/intrface/prdouitsParCat.php?id=<?php echo $cat['id'] ?>&nom_cat=<?php echo $cat['nom'] ?>">
                            <?php echo $cat['nom'] ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </main>
        </div>
    </div>
</section>
<?php 
}
?>
