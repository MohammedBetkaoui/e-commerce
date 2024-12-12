<?php
include('../include/connection.php');

$id_cat = $_GET['id'];
$nom_cat = $_GET['nom_cat'];
  $req="SELECT produits.*, categorie.nom AS categorie_nom
FROM produits
INNER JOIN categorie ON produits.id_categorie = categorie.id  WHERE categorie.id = $id_cat;";




 $resultat=mysqli_query($connection,$req);
 $tab = mysqli_fetch_assoc($resultat);
 $num=mysqli_num_rows($resultat);
       
 include('../include/navClient.php');
    ?>
<br>
<?php include('../include/debut.php') ?> 

  <!-- product section -->

  <section class="product_section layout_padding">
    <div class="container">
        
      <div class="heading_container heading_center">
        
            <?php  if($num>0){ ?><h2><?php echo $tab['categorie_nom']  ?> </h2> 
                        
              
            <?php }else{
                      ?><h3>la list des produits dans la catégorie <b><?php echo $nom_cat ?></b>  est vide </h3>
           <?php  }?>
         
        
      </div>

    

      <section class="product_section layout_padding">
    <div class="container">
<?php include('../intrface/categorie.php'); ?>        

<!-- Affichage des produits -->
       

        <div class="container">
            <?php 
            $count = 0;
            while ($produit = $resultat->fetch_assoc()) { 
                if ($count % 3 === 0) {
                    echo '<div class="row mb-4">'; // Nouvelle ligne
                }
            ?>
                <div class="col-md-4">
                    <div class="box">
                        <div class="img-box">
                            <a href="produit.php?id=<?= htmlspecialchars($produit['id']) ?>" class="btn stretched-link"></a>
                            <img src="/images/produit/<?= htmlspecialchars($produit['image_url']) ?>" alt="Image de <?= htmlspecialchars($produit['nom_produit']) ?>">
                            <?php if (isset($_SESSION['id_c'])) { ?>
                                <a href="produit.php?id=<?= htmlspecialchars($produit['id']) ?>" class="add_cart_btn">
                                    <span>Ajouter au panier</span>
                                </a>
                            <?php } ?>
                               
                            
                        </div>
                        <div class="detail-box">
                            <!-- Nom produit -->
                            <div class="product-name">
                                <?= htmlspecialchars($produit['nom_produit']) ?>
                            </div>
                            <!-- Description -->
                            <div class="product-desc">
                                <?= htmlspecialchars($produit['description']) ?>
                            </div>
                            <!-- Prix -->
                            <div class="product-price">
                                <?= htmlspecialchars($produit['prix']) ?> <span>dz</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                $count++;
                if ($count % 3 === 0) {
                    echo '</div>';
                }
            }
            if ($count % 3 !== 0) {
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Pagination -->
    <br><br>
   
</section>

    </div>
  </section>

<?php include('../include/fin.php') ?>