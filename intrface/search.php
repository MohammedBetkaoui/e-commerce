<?php
include('../include/connection.php');
include('../include/navClient.php'); // Inclure la navigation

// Récupérer la requête de recherche
$searchQuery = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';

// Vérifier si une recherche a été effectuée
if (!empty($searchQuery)) {
    // Construire la requête SQL pour les produits correspondant à la recherche
    $req = "SELECT * FROM produits 
            WHERE nom_produit LIKE ? 
            OR description LIKE ?";
    $stmt = $connection->prepare($req);
    $searchParam = "%$searchQuery%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $num = $resultat->num_rows;
} else {
    $num = 0;
}

?>
<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <?php if ($num > 0) { ?>
            <h2 class="results-header">Résultats pour : <span>"<?= htmlspecialchars($searchQuery) ?>"</span></h2>
            <?php } else { ?>
            <h2 class="no-results-header">Aucun produit trouvé pour : <span>"<?= htmlspecialchars($searchQuery) ?>"</span></h2>
            <?php } ?>
        </div>
        <!-- Produits affichés ici -->
        <div class="row">
            <?php if ($num > 0) { 
                foreach ($resultat as $produit) { ?>
            <div class="box">
                <div class="img-box">
                    <a href="produit.php?id=<?= $produit['id'] ?>" class="btn stretched-link"></a>
                    <img src="/images/produit/<?= $produit['image_url'] ?>" alt="<?= $produit['nom_produit'] ?>">
                    <?php if (isset($_SESSION['id_c'])) { ?>
                    <a href="produit.php?id=<?= $produit['id'] ?>" class="add_cart_btn">Add To Cart</a>
                    <?php } elseif (!isset($_SESSION['id_c']) && !isset($_SESSION['id']) && !isset($_SESSION['id_a'])) { ?>
                    <a href="../intrface/index.php" class="add_cart_btn">Add To Cart</a>
                    <?php } ?>
                </div>
                <div class="detail-box">
                    <h5><?= htmlspecialchars($produit['nom_produit']) ?></h5>
                    <p><?= htmlspecialchars($produit['description']) ?></p>
                    <div class="product_info">
                        <h5><?= htmlspecialchars($produit['prix']) ?> <span>dz</span></h5>
                    </div>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
</section>

<style>
/* Modern grid layout */
.heading_container h2 {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
    padding: 10px 15px;
    border-radius: 8px;
}

/* Style for "Résultats pour :" */
.heading_container .results-header {
    background-color: #e3f2fd; /* Light blue background */
    color: #1565c0; /* Blue text */
    border: 1px solid #90caf9; /* Light blue border */
}

/* Style for "Aucun produit trouvé pour :" */
.heading_container .no-results-header {
    background-color: #ffebee; /* Light red background */
    color: #d32f2f; /* Red text */
    border: 1px solid #ef9a9a; /* Light red border */
    font-style: italic;
}


.product_section .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

/* Product card */
.box {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.box:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.img-box {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
}

.img-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.img-box:hover img {
    transform: scale(1.1);
}

.add_cart_btn {
    text-align: center;
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: #ff6f61;
    color: #fff;
    padding: 10px 15px;
    border-radius: 30px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: background 0.3s;
}

.add_cart_btn:hover {
    background: #e05a50;
}

.detail-box {
    padding: 15px;
    text-align: center;
}

.detail-box h5 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.detail-box p {
    font-size: 14px;
    color: #777;
    margin-bottom: 15px;
}

.product_info {
    font-size: 16px;
    color: #000;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .row {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    .img-box {
        height: 150px;
    }
}
</style>


