<?php
session_start();

include('../../include/connection.php');
include('../../include/nav.php');
echo '<br><br>';

if (isset($_SESSION['id'])) {
?>
    <title>Comptes Bloqués</title>
    <!-- Boutons de navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a class="btn btn-dark mx-2" href="/intrface/admin/Utilisateurs.php">Tout</a>
        <a class="btn btn-dark mx-2" href="/intrface/admin/admin.php">Admin</a>
        <a class="btn btn-dark mx-2" href="/intrface/admin/clients.php">Client</a>
    </div>

    <!-- Affichage des comptes bloqués -->
    <?php 
    $sql = "SELECT users.* FROM users JOIN block ON users.email = block.email_user";
    $res = mysqli_query($connection, $sql);
    $num = mysqli_num_rows($res);

    if ($num <= 0) {
    ?>
        <div class="text-center mt-5 alert alert-danger">
            <h5>Aucun utilisateur trouvé</h5>
        </div>
    <?php
    } else {
    ?>
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prenom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($res as $user) { 
                    ?>
                        <tr class="user-row" data-id="<?= $user['id']; ?>" data-name="<?= $user['nom'] . ' ' . $user['prenom']; ?>" data-email="<?= $user['email']; ?>">
                            <td data-label="Nom"><?= $user['nom']; ?></td>
                            <td data-label="Prenom"><?= $user['prenom']; ?></td>
                            <td data-label="Email"><?= $user['email']; ?></td>
                            <td data-label="Role"><?= $user['role']; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    ?>

    <!-- Modale pour choisir une opération -->
    <div class="modal fade" id="operationModal" tabindex="-1" aria-labelledby="operationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="operationModalLabel">Opérations sur l'utilisateur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="selectedUserName" class="text-center fs-5"></p>
                    <div class="d-flex justify-content-around mt-4">
                        <a id="blockUserLink" href="#" class="btn btn-success">Débloquer</a>
                        <a id="deleteUserLink" href="#" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    header('location: ../index.php');
}
?>

<!-- CSS pour le thème sombre -->

<script>
    // Ajouter un événement à chaque ligne d'utilisateur
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', () => {
            const userId = row.getAttribute('data-id');
            const userName = row.getAttribute('data-name');
            const userEmail = row.getAttribute('data-email');

            // Mettre à jour le nom de l'utilisateur dans la modale
            document.getElementById('selectedUserName').innerText = `Utilisateur sélectionné : ${userName}`;

            // Mettre à jour les liens pour bloquer et supprimer
            document.getElementById('blockUserLink').setAttribute('href', `/php/unblock.php?email=${userEmail}`);
            document.getElementById('deleteUserLink').setAttribute('href', `/php/supUser.php?id=${userId}`);

            // Afficher la modale
            const modal = new bootstrap.Modal(document.getElementById('operationModal'));
            modal.show();
        });
    });

    // Confirmer l'action avant d'exécuter
    document.getElementById('deleteUserLink').addEventListener('click', function (e) {
        const userName = document.getElementById('selectedUserName').innerText.replace('Utilisateur sélectionné : ', '');
        if (!confirm(`Voulez-vous vraiment supprimer le compte de ${userName} ?`)) {
            e.preventDefault();
        }
    });

    document.getElementById('blockUserLink').addEventListener('click', function (e) {
        const userName = document.getElementById('selectedUserName').innerText.replace('Utilisateur sélectionné : ', '');
        if (!confirm(`Voulez-vous vraiment débloquer le compte de ${userName} ?`)) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>
