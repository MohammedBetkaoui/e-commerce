<?php 
session_start();

include('../../include/connection.php');
include('../../include/nav.php');
echo '<br><br>';

if (isset($_SESSION['id'])) {
    ?>
    <title>Toutes les Catégories</title>

    <!-- Barre de recherche -->
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Rechercher une catégorie...">
    </div>
    <br>

    <div class="container">
        <br>
        <!-- Bouton d'ajout de catégorie -->
        <div class="text-center">
            <a class="btn btn-add-category mb-3" href="./ajouterCatigorie.php">Ajouter une catégorie</a>
        </div><br><br>

        <!-- Tableau des catégories -->
        <table class="table table-bordered table-dark custom-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom de catégorie</th>
                </tr>
            </thead>
            <tbody id="categoriesTableBody">
                <?php
                $req = "SELECT * FROM `categorie`";
                $categories = mysqli_query($connection, $req);
                $num = mysqli_num_rows($categories);

                if ($num > 0) {
                    foreach ($categories as $categorie) { 
                ?>
                    <tr class="category-row" data-id="<?= $categorie['id']; ?>" 
                                             data-name="<?= $categorie['nom']; ?>">

                        <td><?php echo $categorie['id']; ?></td>
                        <td><?php echo $categorie['nom']; ?></td>
                       
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="3" class="text-center">La liste des catégories est vide !</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

<?php
} else {
    header('location: ../index.php');
}
?>

<!-- Modale pour confirmation de suppression -->
<div class="modal fade" id="operationModal" tabindex="-1" aria-labelledby="operationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="operationModalLabel">Opération de suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalCategoryName" class="text-center fs-5"></p>
                <div class="d-flex justify-content-around mt-4">
                    <a id="deleteCategoryLink" href="#" class="btn btn-danger">Supprimer</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajouter le script de confirmation -->
<script>
    // Ajouter un événement de clic pour chaque ligne de catégorie
    document.querySelectorAll('.category-row').forEach(row => {
        row.addEventListener('click', function() {
            const categoryId = row.getAttribute('data-id');
            const categoryName = row.getAttribute('data-name');

            // Mettre à jour le nom de la catégorie dans la modale
            document.getElementById('modalCategoryName').innerText = `Voulez-vous vraiment supprimer la catégorie : ${categoryName}?`;

            // Mettre à jour le lien de suppression avec l'ID de la catégorie
            document.getElementById('deleteCategoryLink').setAttribute('href', `../../php/supCat.php?id=${categoryId}`);

            // Ouvrir la modale
            const modal = new bootstrap.Modal(document.getElementById('operationModal'));
            modal.show();
        });
    });

    // Fonction de recherche
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const rows = document.querySelectorAll('.category-row');

        rows.forEach(row => {
            const categoryName = row.getAttribute('data-name').toLowerCase();

            if (categoryName.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<style>
  /* Container de la barre de recherche */
  .search-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
  }

  /* Champ de recherche */
  .search-input {
    border: none;
    outline: none;
    padding: 10px;
    font-size: 16px;
    width: 80%;
    max-width: 600px;
    border-radius: 25px;
    background-color: #f8f8f8;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  /* Effet de focus sur le champ de recherche */
  .search-input:focus {
    border: 2px solid #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
  }

  /* Style général de la table */
  .table {
    width: 100%;
    border-collapse: collapse;
    background-color: #343a40; /* Couleur de fond sombre */
    color: #fff; /* Texte blanc */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }

  /* Entête de table */
  .table thead {
    background-color: #343a40;
    color: #fff;
  }

  /* Lignes de la table */
  .table tbody tr {
    border-bottom: 1px solid #ddd;
  }

  /* Cellules de la table */
  .table td, .table th {
    padding: 12px;
    text-align: center;
  }

  /* Boutons d'actions (ajouter, modifier) */
  .btn {
    padding: 8px 16px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  /* Style du bouton "Ajouter une catégorie" */
  .btn-add-category {
    padding: 12px 30px; /* Taille du bouton */
    font-size: 16px; /* Taille de la police */
    font-weight: bold; /* Texte en gras */
    background-color: #28a745; /* Couleur verte */
    border: none; /* Enlever la bordure */
    color: white; /* Texte blanc */
    border-radius: 50px; /* Bordure arrondie */
    text-align: center; /* Centrer le texte */
    box-shadow: 0 4px 8px rgba(0, 128, 0, 0.3); /* Ombre du bouton */
    cursor: pointer; /* Curseur en forme de main */
    transition: all 0.3s ease; /* Transition lors du survol */
  }

  /* Effet de survol du bouton */
  .btn-add-category:hover {
    background-color: #218838; /* Changer la couleur en plus foncé */
    box-shadow: 0 6px 12px rgba(0, 128, 0, 0.4); /* Ombre plus grande lors du survol */
    transform: translateY(-2px); /* Légère élévation du bouton lors du survol */
  }

  /* Effet de focus sur le bouton */
  .btn-add-category:focus {
    outline: none; /* Retirer la bordure lors du focus */
    box-shadow: 0 0 5px rgba(0, 255, 0, 0.5); /* Ombre verte autour du bouton */
  }

  .btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
  }

  .btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
  }

  /* Message lorsque la liste est vide */
  .text-cente {
    font-size: 18px;
    color: #dc3545;
    font-weight: bold;
  }

  /* Centrer le bouton avec un style CSS personnalisé */
  .text-center {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%; /* Assurer que l'élément occupe toute la largeur */
  }

  /* Responsivité */
  @media (max-width: 768px) {
    .table td, .table th {
      font-size: 12px;
      padding: 8px;
    }

    .btn {
      padding: 6px 12px;
      font-size: 12px;
    }
  }
</style>
