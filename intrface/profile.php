<?php 
include('../include/navClient.php');

if (!isset($_SESSION['id_c'])) {
    header("Location: ../../../intrface/index.php");
    exit();
}

include('../include/connection.php');

if (!$connection) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}

$id_c = $_SESSION['id_c'];

$sql = "SELECT 
            produits.nom_produit,
            commende.id,
            commende.status,
            commende.prix_total,
            commende.quantité,
            commende.date,
            GROUP_CONCAT(produit_images.image_url) AS images
        FROM
            commende
        JOIN produits ON commende.id_produit = produits.id
        JOIN produit_images ON produits.id = produit_images.produit_id
        WHERE
            commende.id_user = $id_c
        GROUP BY commende.id";

$res = mysqli_query($connection, $sql);

if (!$res) {
    die("Erreur de requête SQL: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Profil | <?php echo $_SESSION['nom_c']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Style personnalisé pour les images */
    .carousel-item img {
        height: 200px;
        width: auto;
        margin: 0 auto;
        object-fit: contain;
    }
    .user-info {
        margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- Informations de l'utilisateur -->
    <div class="container-xl px-4 mt-4">
    <div class="container-xl px-4 mt-4">
    <!-- Informations de l'utilisateur -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Informations de l'utilisateur</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-fill fs-3 me-3 text-primary"></i>
                        <div>
                            <h6 class="mb-1">Nom et Prénom :</h6>
                            <p class="mb-0 fw-bold"><?= $_SESSION['nom_c'] . ' ' . $_SESSION['prenom_c']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope-fill fs-3 me-3 text-primary"></i>
                        <div>
                            <h6 class="mb-1">Email :</h6>
                            <p class="mb-0 fw-bold"><?= $_SESSION['email_c']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone-fill fs-3 me-3 text-primary"></i>
                        <div>
                            <h6 class="mb-1">Téléphone :</h6>
                            <p class="mb-0 fw-bold">0<?= $_SESSION['tlf_c']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- Tableau des commandes -->
        <div class="card mb-4">
            <div class="card-body p-0">
                <div class="table-responsive table-billing-history">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID-Commande</th>
                                <th scope="col">Date</th>
                                <th scope="col">Images de produit</th>
                                <th scope="col">Nom de produit</th>
                                <th scope="col">Quantité</th>
                                <th scope="col">Prix Total</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($com = mysqli_fetch_assoc($res)): ?>
                                <tr>
                                    <td><?= $com['id'] ?></td>
                                    <td><?= $com['date'] ?></td>
                                    <td>
                                        <!-- Bootstrap Carrousel -->
                                        <div id="carouselCommande<?= $com['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php 
                                                $images = explode(',', $com['images']);
                                                foreach ($images as $index => $image): 
                                                ?>
                                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                        <img src="/images/produit/<?= $image ?>" alt="Image de produit">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCommande<?= $com['id'] ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Précédent</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselCommande<?= $com['id'] ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Suivant</span>
                                            </button>
                                        </div>
                                    </td>
                                    <td><?= $com['nom_produit'] ?></td>
                                    <td><?= $com['quantité'] ?></td>
                                    <td><?= $com['prix_total'] ?>€</td>
                                    <td>
                                        <?php if ($com['status'] =='En cours'): ?>
                                            <span class="badge bg-success">En cours</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">En cours</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
