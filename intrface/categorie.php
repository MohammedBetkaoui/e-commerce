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
            <div class="categories_row">
                <?php foreach ($res as $cat) { ?>
                    <div class="category_card">
                        <a href="/intrface/prdouitsParCat.php?id=<?php echo $cat['id'] ?>&nom_cat=<?php echo $cat['nom'] ?>">
                            <div class="card_content">
                                <h3><?php echo $cat['nom']; ?></h3>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
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
            <div class="categories_row">
                <?php foreach ($res as $cat) { ?>
                    <div class="category_card">
                        <a href="/intrface/prdouitsParCat.php?id=<?php echo $cat['id'] ?>&nom_cat=<?php echo $cat['nom'] ?>">
                            <div class="card_content">
                                <h3><?php echo $cat['nom']; ?></h3>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>



<?php 
}
?>
<style>
/* Conteneur des catégories */
.categories_row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 0 15px;
}

/* Cartes */
.category_card {
    width: 250px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 20px;
    transition: all 0.3s ease;
}

/* Survol */
.category_card:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}

/* Contenu de la carte */
.card_content h3 {
    font-size: 1.2rem;
    color: #444;
    margin: 0;
}

</style>
