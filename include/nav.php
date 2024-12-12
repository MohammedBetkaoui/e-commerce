<?php 
if(!isset($_SESSION)){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/btk.css">
    <link rel="stylesheet" href="/css/form.css">
    <link rel="stylesheet" href="/css/nav.css">
    <script src="/css/scripte/produit.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      
       
            <a class="navbar-brand" href="/intrface/homeClient.php"><h4><img width="30" height="30" src="/client/images/fevicon.png" alt="logo"></h4></a>
       
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="/intrface/admin/home.php"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/commende.php"><i class="fas fa-box"></i> Les Commandes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/categories.php"><i class="fas fa-list"></i> Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/produits.php"><i class="fas fa-tag"></i> Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/Utilisateurs.php"><i class="fas fa-users"></i> Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/analyse.php"><i class="fas fa-users"></i> Analyse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/homeClient.php"><i class="fas fa-globe"></i> Le Site Web</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/logout.php"><i class="fas fa-sign-out-alt"></i> Se Déconnecter</a>
                    </li>
                <?php elseif(isset($_SESSION['id_a'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="/intrface/admin/home.php"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/AjoutProduit.php"><i class="fas fa-plus"></i> Ajouter Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/admin/produits.php"><i class="fas fa-tag"></i> Tous les Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/homeClient.php"><i class="fas fa-globe"></i> Le Site Web</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/php/logout.php"><i class="fas fa-sign-out-alt"></i> Se Déconnecter</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="/intrface/homeClient.php"><i class="fas fa-home"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/index.php"><i class="fas fa-sign-in-alt"></i> Se Connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/intrface/inscription.php"><i class="fas fa-user-plus"></i> S'inscrire</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
