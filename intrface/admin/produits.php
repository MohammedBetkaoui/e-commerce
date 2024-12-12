<?php 
session_start();
include('../../include/connection.php');
include('../../include/nav.php'); 
echo '<br><br>'; 

if(isset($_SESSION['id']) || isset($_SESSION['id_a'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="text-light">

<div class="container mt-5">

    <!-- Barre de recherche -->
    <div class="d-flex justify-content-between mb-3">
        <input id="searchInput" type="text" class="form-control" placeholder="Rechercher un produit..." style="width: 70%">
        <a href="/intrface/admin/AjoutProduit.php" class="btn btn-success">Ajouter un produit</a>
    </div>
    
    <!-- Tableau des produits -->
    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Nom de produit</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Description</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Prix</th>
                    <th scope="col">date de creation</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <?php
                $req = "SELECT produits.*, categorie.nom AS categorie_nom 
                        FROM produits
                        INNER JOIN categorie ON produits.id_categorie = categorie.id;";
                $resultat = mysqli_query($connection, $req);

                if(mysqli_num_rows($resultat) > 0) {
                    foreach($resultat as $produit) { 
                        // Récupérer les images pour ce produit
                        $product_id = $produit['id'];
                        $imageQuery = "SELECT image_url FROM produit_images WHERE produit_id = $product_id";
                        $imageResult = mysqli_query($connection, $imageQuery);
                        $images = mysqli_fetch_all($imageResult, MYSQLI_ASSOC);
                ?>
                <tr class="product-row" data-id="<?= $produit['id']; ?>"
                                        data-name="<?= $produit['nom_produit']; ?>" 
                                        data-category="<?= $produit['categorie_nom']; ?>" 
                                        data-quantity="<?= $produit['quantité']; ?>" 
                                        data-price="<?= $produit['prix']; ?>" 
                                        data-created_at="<?= $produit['date_created']; ?>"
                                        data-description="<?= $produit['description']; ?>">

                    <!-- Carrousel d'images -->
                    <td>
                        <?php if (count($images) > 0): ?>
                        <div id="productCarousel<?= $produit['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $activeClass = 'active';
                                foreach ($images as $image) {
                                    echo '<div class="carousel-item ' . $activeClass . '">
                                            <img src="/images/produit/' . htmlspecialchars($image['image_url']) . '" class="d-block w-100" alt="Image produit" style="height: 60px; object-fit: contain;">
                                          </div>';
                                    $activeClass = ''; // L'image suivante ne sera pas active
                                }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel<?= $produit['id']; ?>" data-bs-slide="prev">
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel<?= $produit['id']; ?>" data-bs-slide="next">
                            </button>
                        </div>
                        <?php else: ?>
                            <img src="/images/produit/default.jpg" alt="Produit" style="width: 60px; border-radius: 5px;">
                        <?php endif; ?>
                    </td>
                    <td><?= $produit['nom_produit']; ?></td>
                    <td><?= $produit['categorie_nom']; ?></td>
                    <td><?= $produit['description']; ?></td>
                    <td><?= $produit['quantité']; ?></td>
                    <td><?= $produit['prix']; ?> €</td>
                    <td><?= !empty($produit['date_created']) ? $produit['date_created'] : 'N/A'; ?></td>
                </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="7">Aucun produit trouvé.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modale pour choisir une opération -->
<div class="modal fade" id="operationModal" tabindex="-1" aria-labelledby="operationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="operationModalLabel">Opérations sur le produit</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="selectedProductName" class="text-center fs-5"></p>
                <div class="d-flex justify-content-around mt-4">
                    <a id="editProductLink" href="#" class="btn btn-primary">Modifier</a>
                    <button id="deleteProductButton" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Ajouter un événement à chaque ligne de produit
document.querySelectorAll('.product-row').forEach(row => {
    row.addEventListener('click', () => {
        const productId = row.getAttribute('data-id');
        const productName = row.getAttribute('data-name');

        // Mettre à jour le nom du produit dans la modale
        document.getElementById('selectedProductName').innerText = `${productName}`;

        // Mettre à jour les liens et actions
        document.getElementById('editProductLink').setAttribute('href', `/php/mod.php?id=${productId}`);
        document.getElementById('deleteProductButton').onclick = function() {
            if (confirm(`Voulez-vous vraiment supprimer le produit "${productName}" ?`)) {
                window.location.href = `/php/sup.php?id=${productId}`;
            }
        };

        // Afficher la modale
        const modal = new bootstrap.Modal(document.getElementById('operationModal'));
        modal.show();
    });
});

// Fonction de recherche
document.getElementById('searchInput').addEventListener('input', function() {
    const searchQuery = this.value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');

    rows.forEach(row => {
        const productName = row.getAttribute('data-name').toLowerCase();
        const description = row.getAttribute('data-description').toLowerCase();
        const category = row.getAttribute('data-category').toLowerCase();
        const quantity = row.getAttribute('data-quantity');
        const price = row.getAttribute('data-price');

        if (productName.includes(searchQuery) || category.includes(searchQuery) || description.includes(searchQuery) || quantity.includes(searchQuery) || price.includes(searchQuery)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<style>
/* Table sombre */
.table-hover tbody tr:hover {
    background-color: #343a40;
    cursor: pointer;
}

/* Image de produit */
.product-row img {
    max-height: 50px;
    object-fit: contain;
}

/* Modale */
.modal-content {
    border-radius: 10px;
}
</style>

</body>
</html>

<?php 
} else {
    header('location: ../index.php');
}
?>
