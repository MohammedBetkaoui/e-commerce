<?php 
include('../include/connection.php');
include('../include/navClient.php');

if ($_SESSION) { 
    $id_c = $_SESSION['id_c'];
    $panier = $_SESSION['panier'][$id_c];
?>
<div class="container mt-5">
    <h2 class="text-center mb-5 text-primary fw-bold">Votre Panier</h2>

    <?php if (empty($panier)) : ?>
        <div class="alert alert-info text-center fs-5">Votre panier est vide.</div>
    <?php else : ?>
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-borderless align-middle">
                <thead class="bg-primary text-light">
                    <tr>
                        <th scope="col">Images</th>
                        <th scope="col">Nom du produit</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix Unitaire</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php 
                    $total_global = 0;
                    foreach ($panier as $id => $qun) {
                        if ($id != 0) {
                            $sql = "SELECT * FROM `produits` WHERE `id`='$id'";
                            $res = mysqli_query($connection, $sql);
                            $row = mysqli_fetch_assoc($res);
                            $sqlImages = "SELECT * FROM `produit_images` WHERE `produit_id` = '$id'";
                            $imagesResult = mysqli_query($connection, $sqlImages);

                            $total = $row['prix'] * $qun;
                            $total_global += $total;
                    ?>
                    <tr>
                        <td data-label="Images">
                            <div id="carousel<?= $id ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php 
                                    $active = true;
                                    while ($image = mysqli_fetch_assoc($imagesResult)) { ?>
                                        <div class="carousel-item <?= $active ? 'active' : '' ?>">
                                            <img src="/images/produit/<?= htmlspecialchars($image['image_url']); ?>" 
                                                class="d-block w-100" 
                                                alt="Produit <?= htmlspecialchars($row['nom_produit']); ?>" 
                                                style="max-height: 150px; object-fit: cover;">
                                        </div>
                                    <?php $active = false; } ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $id ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Précédent</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $id ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Suivant</span>
                                </button>
                            </div>
                        </td>
                        <td data-label="Nom du produit"><?= htmlspecialchars($row['nom_produit']); ?></td>
                        <td data-label="Quantité">
                            <input 
                                type="number" 
                                class="form-control text-center update-quantity" 
                                data-id="<?= $id ?>" 
                                value="<?= $qun ?>" 
                                min="1">
                        </td>
                        <td data-label="Prix Unitaire"><?= htmlspecialchars($row['prix']) ?> DZ</td>
                        <td data-label="Total"><?= htmlspecialchars($total) ?> DZ</td>
                        <td data-label="Action">
                            <button class="btn btn-danger btn-sm remove-item" data-id="<?= $id ?>">Retirer</button>
                            <a href="/php/commende.php?id=<?php echo $_SESSION['id_c']?>&id_p=<?php echo $id ?>&qun=<?php echo $qun?>&total=<?php echo $total ?>">
                                <button type="button" class="btn btn-primary btn-sm mt-2">Commander</button>
                            </a>
                        </td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <h4 class="text-dark fw-bold">Total Global : 
                <span class="text-success"><?= number_format($total_global, 2) ?> DZ</span>
            </h4>
        </div>
    <?php endif; ?>
</div>

<?php 
} else {
    header('location: ../intrface/index.php');
} 
?>

<!-- Toast Notifications -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toastNotification" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Action effectuée avec succès !
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {
    const toastElement = $('#toastNotification');

    function showToast(message, type = 'primary') {
        const toast = new bootstrap.Toast(toastElement);
        toastElement.removeClass('bg-primary bg-success bg-danger').addClass(`bg-${type}`);
        toastElement.find('.toast-body').text(message);
        toast.show();
    }

    $('.update-quantity').on('change', function () {
        const id = $(this).data('id');
        const quantity = $(this).val();

        if (quantity < 1) {
            showToast('La quantité doit être au moins 1.', 'danger');
            $(this).val(1);
            return;
        }

        $.ajax({
            url: './updatePanier.php',
            type: 'POST',
            data: { id: id, quantity: quantity },
            success: function () {
                const row = $(`.update-quantity[data-id="${id}"]`).closest('tr');
                const unitPrice = parseFloat(row.find('[data-label="Prix Unitaire"]').text());
                const newTotal = unitPrice * quantity;
                row.find('[data-label="Total"]').text(newTotal.toFixed(2) + ' DZ');

                let totalGlobal = 0;
                $('[data-label="Total"]').each(function () {
                    totalGlobal += parseFloat($(this).text());
                });
                $('h4 span').text(totalGlobal.toFixed(2) + ' DZ');

                showToast('Quantité mise à jour avec succès.', 'success');
            },
            error: function () {
                showToast('Erreur lors de la mise à jour.', 'danger');
            }
        });
    });

    $('.remove-item').on('click', function () {
        const id = $(this).data('id');
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
            $.ajax({
                url: './removePanier.php',
                type: 'POST',
                data: { id: id },
                success: function () {
                    $(`.remove-item[data-id="${id}"]`).closest('tr').fadeOut(300, function () {
                        $(this).remove();

                        let totalGlobal = 0;
                        $('[data-label="Total"]').each(function () {
                            totalGlobal += parseFloat($(this).text());
                        });
                        $('h4 span').text(totalGlobal.toFixed(2) + ' DZ');

                        if ($('tbody tr').length === 0) {
                            $('.table-responsive').html('<div class="alert alert-info text-center fs-5">Votre panier est vide.</div>');
                        }

                        showToast('Article supprimé avec succès.', 'success');
                    });
                },
                error: function () {
                    showToast('Erreur lors de la suppression.', 'danger');
                }
            });
        }
    });
});
</script>
<style>
/* Table Styling */
.table {
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ddd;
}
.table thead {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: #fff;
}
.table tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.3s ease;
}
.carousel-inner {
    border-radius: 8px;
}
.toast {
    border-radius: 8px;
    opacity: 0.95;
}
</style>
