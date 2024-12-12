<?php
session_start();
include('../../include/connection.php');
include('../../include/nav.php');
echo '<br>';

if (isset($_SESSION['id'])) {
    $sql = "SELECT 
                produits.nom_produit,
                users.nom AS nom_user,
                users.prenom AS prenom_user,
                users.tlf AS tlf_user,
                commandes.id,
                commandes.status,
                commandes.prix_total,
                commandes.quantité,
                commandes.date,
                produits.id AS produit_id
            FROM
                commandes
            JOIN produits ON commandes.id_produit = produits.id
            JOIN users ON commandes.id_user = users.id 
            ORDER BY commandes.status ASC, commandes.date ASC";

    $res = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($res);

    if ($num > 0) {
?>
        <title>Liste des commandes</title>

        <div class="container mt-4">
            <h2 class="text-center mb-4">Liste des commandes</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Client</th>
                            <th scope="col">Date-Heure</th>
                            <th scope="col">Images</th>
                            <th scope="col">Nom de produit</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Prix Total</th>
                            <th scope="col">Confirmation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($res as $com) { 
                            $produit_id = htmlspecialchars($com['produit_id']);
                            // Fetch all images for the current product
                            $imagesQuery = "SELECT * FROM produit_images WHERE produit_id = '$produit_id'";
                            $imagesResult = mysqli_query($connection, $imagesQuery);
                        ?>
                            <tr>
                                <td data-label="Client">
                                    <strong><?php echo htmlspecialchars($com['nom_user'] . ' ' . $com['prenom_user']); ?></strong>
                                    <br>
                                    <small>Numéro de téléphone : <strong><?php echo '0' . htmlspecialchars($com['tlf_user']); ?></strong></small>
                                </td>
                                <td data-label="Date-Heure"><?php echo htmlspecialchars($com['date']); ?></td>
                                <td data-label="Images">
                                    <!-- Carousel for product images -->
                                    <div id="carousel<?= $produit_id ?>" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php 
                                            $active = true;
                                            while ($image = mysqli_fetch_assoc($imagesResult)) { 
                                            ?>
                                                <div class="carousel-item <?= $active ? 'active' : '' ?>">
                                                    <img 
                                                        src="/images/produit/<?= htmlspecialchars($image['image_url']); ?>" 
                                                        class="d-block w-100" 
                                                        alt="Produit <?= htmlspecialchars($com['nom_produit']); ?>" 
                                                        style="max-height: 150px; object-fit: cover;">
                                                </div>
                                            <?php 
                                                $active = false;
                                            } 
                                            ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $produit_id ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Précédent</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $produit_id ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Suivant</span>
                                        </button>
                                    </div>
                                </td>
                                <td data-label="Nom de produit"><?php echo htmlspecialchars($com['nom_produit']); ?></td>
                                <td data-label="Quantité"><?php echo htmlspecialchars($com['quantité']); ?></td>
                                <td data-label="Prix Total"><?php echo htmlspecialchars($com['prix_total']) . '.00 DZ'; ?></td>
                                <td data-label="Confirmation">
                                    <?php if ($com['status'] == 0) { ?>
                                        <a class="btn btn-primary btn-sm px-3 py-2" href="/php/confermerCom.php?id=<?= htmlspecialchars($com['id']); ?>">
                                            <i class="bi bi-check-circle"></i> Confirmer
                                        </a>
                                    <?php } else { ?>
                                        <a class="btn btn-success btn-sm px-3 py-2" href="./supprimerCommned.php?id=<?= htmlspecialchars($com['id']); ?>">
                                            <i class="bi bi-check-lg"></i> Confirmé
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
<?php
    } else {
?>
        <div class="container mt-4">
            <h3 class="text-center alert alert-danger">Il n'y a aucune commande pour le moment</h3>
        </div>
<?php
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<style>
/* Carousel styling */
.carousel img {
    max-height: 150px;
    object-fit: cover;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(100%);
}

/* Table styling */
.table img {
    border-radius: 5px;
}
</style>
