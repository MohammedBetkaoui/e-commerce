// Barre de recherche dynamique pour filtrer la table
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll(".custom-table tbody tr");

        rows.forEach(row => {
            const cells = row.getElementsByTagName("td");
            let match = false;

            for (let i = 0; i < cells.length; i++) {
                if (cells[i].innerText.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }

            row.style.display = match ? "" : "none";
        });
    });
});

  // Exemple de validation de formulaire (basique)
  document.querySelector('form').addEventListener('submit', function(event) {
    var nomProduit = document.getElementById('nomP').value;
    var prixProduit = document.getElementById('prix').value;
    var descriptionProduit = document.getElementById('description').value;

    if (nomProduit === "" || prixProduit === "" || descriptionProduit === "") {
        alert('Veuillez remplir tous les champs.');
        event.preventDefault();
    }
});

function confirmDelete(id, name) {
    const confirmMessage = `Voulez-vous vraiment supprimer la catégorie ${name} ?`;

    if (confirm(confirmMessage)) {
        // Si l'utilisateur confirme, on redirige vers le script de suppression
        window.location.href = `../../php/supCat.php?id=${id}`;
    }
}



    // Sauvegarder la position de défilement avant de quitter la page
    window.onbeforeunload = function() {
        localStorage.setItem('scrollPosition', window.scrollY || document.documentElement.scrollTop);
    };

    // Restaurer la position de défilement après le chargement de la page
    window.onload = function() {
        if (localStorage.getItem('scrollPosition')) {
            window.scrollTo(0, localStorage.getItem('scrollPosition'));
        }
    };
// Script pour faire fonctionner la recherche
document.querySelector('.search-bar').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.querySelector('.search-bar input').value;
    if (query) {
      window.location.href = 'search.php?query=' + encodeURIComponent(query);
    }
  });
  