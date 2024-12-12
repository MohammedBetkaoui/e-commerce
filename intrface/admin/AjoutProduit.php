<?php 
    session_start();
    include('../../include/connection.php');
    include('../../include/nav.php');  

    if (isset($_SESSION['id']) || isset($_SESSION['id_a'])) { 
?>

<title>Ajouter Produit</title>

<!-- Formulaire pour l'ajout de produit -->
<div class="container mt-5">
    <h2 class="text-center text-light">Ajouter un Produit</h2>
    <form action="/php/ajouteProduit.php" method="post" enctype="multipart/form-data" id="addProductForm">

        <!-- Nom du produit -->
        <div class="form-group mb-3">
            <input type="text" class="form-control" id="nomP" name="nomP" placeholder="Libbelle" required>
        </div>
        
        <!-- Catégorie du produit -->
        <div class="form-group mb-3">
            <select name="catigorie" class="form-select" id="catigorie" required>
                <option value="">Choisissez une catégorie</option>
                <?php 
                    $query = "SELECT * FROM categorie";
                    $res = mysqli_query($connection, $query);
                    foreach ($res as $categorie) {
                        echo "<option value='" . $categorie['id'] . "'>" . $categorie['nom'] . "</option>";
                    }
                ?>
            </select>
        </div>

        <!-- Images du produit -->
    <div class="form-group mb-3">
        <input type="file" class="form-control" name="images[]" id="images" multiple required accept="image/*">
    </div>

        <!-- Description du produit -->
        <div class="form-group mb-3">
            <textarea name="description" class="form-control" id="description" placeholder="Description" required></textarea>
        </div>

        <!-- Prix du produit -->
        <div class="form-group mb-3">
            <input type="number" class="form-control" name="prix" id="prix" placeholder="Prix (dz)" required min="0" step="0.01">
        </div>

        <!-- Quantité -->
        <div class="form-group mb-3">
            <input class="form-control" name="quantité" placeholder="Quantité" type="number" min="1" value="1" required>
        </div>

        <!-- Bouton de soumission -->
        <div class="form-group mb-3">
            <button class="btn btn-success w-100" type="submit" name="submit">Ajouter Produit</button>
        </div>

    </form>
</div>

<!-- JavaScript de validation et d'amélioration de l'UX -->
<script>
// Validation simple côté client
document.getElementById('addProductForm').addEventListener('submit', function(event) {
    const name = document.getElementById('nomP').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('prix').value;
    const quantity = document.getElementById('quantité').value;
    
    if (!name || !description || !price || !quantity) {
        alert('Veuillez remplir tous les champs avant de soumettre le formulaire.');
        event.preventDefault();
    }
});
</script>

<style>
/* Améliorer le style du formulaire */
.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
    background-color: #343a40;
    border-radius: 8px;
}

h2 {
    color: #fff;
    margin-bottom: 20px;
}

/* Bouton de soumission */
.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    transition: background-color 0.3s ease;
}

.btn-success:hover {
    background-color: #218838;
}

/* Labels et texte */
.form-label {
    color: #fff;
}

/* Champs de formulaire */
.form-control {
    background-color: #495057;
    border: 1px solid #6c757d;
    color: white;
}

.form-control:focus {
    background-color: #343a40;
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5);
}

textarea {
    resize: vertical;
}

</style>

<?php 
    } else {
        header('location: ../index.php');
    }
?>                      