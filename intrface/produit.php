<?php
include('../include/connection.php');
include('../include/navClient.php');

// Vérifier si l'identifiant du produit est fourni et valide
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('<p>Produit non spécifié ou identifiant invalide. Veuillez sélectionner un produit valide.</p>');
}

$id = intval($_GET['id']);

// Fonction pour récupérer les détails du produit
function getProduct($connection, $id) {
    $query = "SELECT * FROM `produits` WHERE `id` = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonction pour récupérer les images du produit
function getProductImages($connection, $productId) {
    $query = "SELECT image_url FROM produit_images WHERE produit_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_url'];
    }
    return $images;
}

$produit = getProduct($connection, $id);
$images = getProductImages($connection, $id);

// Vérification de l'existence du produit
if (!$produit) {
    die('<p>Produit introuvable. Veuillez vérifier l’identifiant fourni.</p>');
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom_produit']) ?> - Boutique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .main {
            max-width: 1400px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .price {
            font-size: 1.8rem;
            font-weight: bold;
            color: #27ae60;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .carousel-indicators [data-bs-target] {
            background-color: #555;
        }

        .product-details {
            padding-left: 30px;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        @media (max-width: 768px) {
            .product-details {
                padding-left: 0;
                text-align: center;
            }

            .product-details h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <main class="main">
        <div class="row">
            <!-- Section gauche : Carousel des images -->
            <div class="col-lg-6">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($images as $index => $image): ?>
                            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php
                        foreach ($images as $index => $image):
                            $activeClass = $index === 0 ? 'active' : '';
                            ?>
                            <div class="carousel-item <?= $activeClass ?>">
                                <img src="/images/produit/<?= htmlspecialchars($image) ?>" class="d-block w-100 product-image" alt="Image de <?= htmlspecialchars($produit['nom_produit']) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"></span>
                    </button>
                </div>
            </div>

            <!-- Section droite : Détails du produit -->
            <div class="col-lg-6 product-details">
                <h1><?= htmlspecialchars($produit['nom_produit']) ?></h1>
                <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>
                <p class="price"><?= number_format($produit['prix'], 2) ?> DZ</p>
                <p class="text-muted">Expédition et taxes en supplément.</p>

                <?php if (isset($_SESSION['id_c'])): ?>
                    <form id="addToCartForm" action="/php/panier.php" method="post">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($produit['id']) ?>">
                        <div class="mb-3">
                            <label for="quantité" class="form-label">Quantité</label>
                            <input 
                                id="quantité" 
                                class="form-control" 
                                name="quantité" 
                                type="number" 
                                min="1" 

                                value="1" 
                                required>
                        </div>
                        <button id="addToCartButton" class="btn btn-primary w-100" type="submit" name="submit">
                            Ajouter au panier
                        </button>
                    </form>
                <?php else: ?>
                    <p>Veuillez <a href="./index.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">vous connecter</a> pour ajouter au panier.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('../include/fin.php'); ?>
