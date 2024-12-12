<?php
session_start();

include('../../include/connection.php');
include('../../include/nav.php');
echo '<br><br>';

if (isset($_SESSION['id'])) {
?>
    <title>Tous les utilisateurs</title>

    <!-- Boutons de navigation -->
    <div class="d-flex justify-content-center mb-4">
        <a class="btn btn-dark mx-2" href="/intrface/admin/AjouterUtilisateur.php">Ajouter</a>
        <a class="btn btn-dark mx-2" href="/intrface/admin/Utilisateurs.php">Tout</a>
        <a class="btn btn-dark mx-2" href="/intrface/admin/clients.php">Client</a>
        <a class="btn btn-danger mx-2" href="/intrface/admin/CompteBlock.php">Les comptes bloqués</a>
    </div>
    <br><br>
    
    <!-- Tableau des utilisateurs -->
    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `users` WHERE `role` = 'admin'";
                $resultat = mysqli_query($connection, $sql);
                $num = mysqli_num_rows($resultat);

                if ($num > 0) {
                    foreach ($resultat as $user) {
                        $email = $user['email'];

                        $req = "SELECT * FROM `block` WHERE `email_user`='$email'";
                        $res = mysqli_query($connection, $req);

                        if ($user['role'] != 'Admin' && mysqli_num_rows($res) == 0) {
                ?>
                            <tr class="user-row" data-id="<?= $user['id']; ?>" data-name="<?= $user['nom'] . ' ' . $user['prenom']; ?>" data-email="<?= $user['email']; ?>">
                                <td data-label="Nom"><?php echo $user['nom']; ?></td>
                                <td data-label="Prenom"><?php echo $user['prenom']; ?></td>
                                <td data-label="Email"><?php echo $user['email']; ?></td>
                            </tr>
                <?php
                        }
                    }
                } else {
                ?>
                    <tr><td colspan="3" class="text-center alert alert-danger">Aucun utilisateur rencontré</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Modale pour confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage" class="text-center fs-5"></p>
                    <div class="d-flex justify-content-around mt-4">
                        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Supprimer</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>


<script>
    // Ajouter un événement à chaque ligne d'utilisateur
    document.querySelectorAll('.user-row').forEach(row => {
        row.addEventListener('click', () => {
            const userId = row.getAttribute('data-id');
            const userName = row.getAttribute('data-name');

            // Mettre à jour le message dans la modale
            document.getElementById('confirmMessage').innerText = `Voulez-vous vraiment supprimer le compte de ${userName} ?`;

            // Mettre à jour le lien de suppression
            document.getElementById('confirmDeleteBtn').setAttribute('href', `/php/supUser.php?id=${userId}`);

            // Afficher la modale
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
</script>

</body>
</html>
