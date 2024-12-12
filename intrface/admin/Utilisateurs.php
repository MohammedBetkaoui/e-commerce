<?php
session_start();

include('../../include/connection.php');
include('../../include/nav.php');
echo '<br><br>';

if (isset($_SESSION['id'])) {
?>
    <title>Gestion des utilisateurs</title>
    <!-- Boutons de navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a class="btn btn-dark mx-2" href="/intrface/admin/admin.php">Admin</a>
        <a class="btn btn-dark mx-2" href="/intrface/admin/clients.php">Client</a>
        <a class="btn btn-danger mx-2" href="/intrface/admin/CompteBlock.php">Les comptes bloqués</a>
    </div>

    <!-- Table des utilisateurs -->
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
            <tbody id="userTableBody">
                <?php
                $sql = "SELECT * FROM `users`";
                $resultat = mysqli_query($connection, $sql);
                $num = mysqli_num_rows($resultat);

                if ($num > 0) {
                    foreach ($resultat as $user) {
                        $email = $user['email'];

                        $req = "SELECT * FROM `block` WHERE `email_user`='$email'";
                        $res = mysqli_query($connection, $req);

                        if ($user['role'] != 'Admin' && mysqli_num_rows($res) == 0) {
                ?>
                            <tr class="user-row" data-id="<?= $user['id']; ?>" data-name="<?= $user['nom'] . ' ' . $user['prenom']; ?>">
                                <td data-label="Nom"><?= $user['nom']; ?></td>
                                <td data-label="Prenom"><?= $user['prenom']; ?></td>
                                <td data-label="Email"><?= $user['email']; ?></td>
                                <td data-label="Role"><?= $user['role']; ?></td>
                            </tr>
                <?php
                        }
                    }
                } else {
                    echo '<tr><td colspan="4">Aucun utilisateur trouvé.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

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
                        <a id="blockUserLink" href="#" class="btn btn-warning">Bloquer</a>
                        <a id="deleteUserLink" href="#" class="btn btn-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

<!-- CSS pour le thème sombre -->
<style>
    body {
        font-family: "Open Sans", sans-serif;
    }

    .table-dark {
        background-color: #181818;
    }

    table th, table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        text-transform: uppercase;
        letter-spacing: .1em;
    }

    .btn-dark {
        background-color: #333;
        border-color: #444;
        color: white;
        transition: background-color 0.3s ease;
    }

    .btn-dark:hover {
        background-color: #555;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #c82333;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #e0a800;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .table-hover tbody tr:hover {
        background-color: #343a40;
        cursor: pointer;
    }

    .table-responsive {
        margin: 20px auto;
        max-width: 100%;
        overflow-x: auto;
    }

    /* Modale */
    .modal-content {
        border-radius: 10px;
    }
</style>

<script>
    // Ajouter un événement à chaque ligne d'utilisateur
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', () => {
            const userId = row.getAttribute('data-id');
            const userName = row.getAttribute('data-name');

            // Mettre à jour le nom de l'utilisateur dans la modale
            document.getElementById('selectedUserName').innerText = `Utilisateur sélectionné : ${userName}`;

            // Mettre à jour les liens pour bloquer et supprimer
            document.getElementById('blockUserLink').setAttribute('href', `/php/blockUser.php?id=${userId}`);
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
        if (!confirm(`Voulez-vous vraiment bloquer le compte de ${userName} ?`)) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>
