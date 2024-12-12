<?php 
include('../include/connection.php');
include('../include/navClient.php');
include('../include/debut.php');

// Fonction pour la pagination et récupération des produits
function getPaginatedProduits($connection, $pageActuelle = 1, $produitsParPage = 9) {
    $pageActuelle = max(1, filter_var($pageActuelle, FILTER_VALIDATE_INT) ?: 1);
    $debut = ($pageActuelle - 1) * $produitsParPage;

    // Récupération des produits avec pagination
    $stmt = $connection->prepare("
        SELECT produits.*, categorie.nom AS categorie_nom 
        FROM produits 
        INNER JOIN categorie ON produits.id_categorie = categorie.id
        LIMIT ?, ?
    ");
    $stmt->bind_param("ii", $debut, $produitsParPage);
    $stmt->execute();
    $produitsResultat = $stmt->get_result();

    // Récupération des catégories
    $catStmt = $connection->prepare("SELECT * FROM categorie");
    $catStmt->execute();
    $categoriesResultat = $catStmt->get_result();

    // Nombre total de produits
    $totalStmt = $connection->prepare("SELECT COUNT(*) as total FROM produits");
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $totalRow = $totalResult->fetch_assoc();
    $totalProduits = $totalRow['total'];
    $totalPages = ceil($totalProduits / $produitsParPage);

    return [
        'produits' => $produitsResultat,
        'categories' => $categoriesResultat,
        'totalProduits' => $totalProduits,
        'totalPages' => $totalPages,
        'pageActuelle' => $pageActuelle
    ];
}

// Récupérer la page actuelle depuis l'URL
$pageActuelle = $_GET['page'] ?? 1;
$produitsParPage = 9;

// Récupération des données via la fonction
$resultats = getPaginatedProduits($connection, $pageActuelle, $produitsParPage);

$produits = $resultats['produits'];
$categories = $resultats['categories'];
$totalPages = $resultats['totalPages'];
$pageActuelle = $resultats['pageActuelle'];
?>

<!-- Contenu principal -->
<section class="product_section layout_padding">
    <div class="container">
        <?php include('../intrface/categorie.php'); ?>        

        <!-- Titre -->
        <div class="heading_container heading_center">
            <h2>
                <?= $produits->num_rows > 0 ? "Tous les produits" : "La liste des produits est vide !" ?>
            </h2>
        </div>

        <!-- Liste des produits -->
        <div class="container">
            <?php 
            $count = 0;
            while ($produit = $produits->fetch_assoc()) { 
                if ($count % 3 === 0) echo '<div class="row mb-4">'; // Nouvelle ligne

                // Récupérer toutes les images associées à ce produit
                $produit_id = $produit['id'];
                $imagesQuery = "SELECT * FROM produit_images WHERE produit_id = $produit_id";
                $imagesResult = mysqli_query($connection, $imagesQuery);
            ?>
                <div class="col-md-4">
                    <div class="box">
                        <!-- Carrousel pour les images -->
                        <div id="carouselProduit<?= $produit_id ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php 
                                $active = true;
                                while ($image = $imagesResult->fetch_assoc()) { ?>
                                    <div class="carousel-item <?= $active ? 'active' : '' ?>">
                                        <img src="/images/produit/<?= htmlspecialchars($image['image_url']) ?>" 
                                             class="d-block w-100" 
                                             alt="Image de <?= htmlspecialchars($produit['nom_produit']) ?>">
                                    </div>
                                <?php 
                                $active = false;
                                } ?>
                            </div>
                            <!-- Contrôles pour changer les images -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduit<?= $produit_id ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduit<?= $produit_id ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div>

                        <!-- Détails du produit -->
                        <div class="detail-box">
                            <div class="product-name">
                                <?= htmlspecialchars($produit['nom_produit']) ?>
                            </div>
                            <div class="product-desc">
                                <?= htmlspecialchars($produit['description']) ?>
                            </div>
                            <div class="product-price">
                                <?= htmlspecialchars($produit['prix']) ?> <span>dz</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                $count++;
                if ($count % 3 === 0) echo '</div>'; // Fermer la ligne
            }
            if ($count % 3 !== 0) echo '</div>'; // Fermer la dernière ligne incomplète
            ?>
        </div>

        <!-- Pagination -->
        <br><br>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= ($pageActuelle == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</section>

<?php include('../include/fin.php'); ?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
