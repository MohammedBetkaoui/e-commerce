<?php
    include('../../include/nav.php');  
    include('../../include/connection.php');

    if (isset($_SESSION['id']) || isset($_SESSION['id_a'])) { 
    // Requête SQL pour récupérer les ventes par catégorie
    $sql = "
        SELECT c.nom AS categorie, SUM(co.prix_total) AS ventes_totales
        FROM commandes AS co
        JOIN produits AS p ON co.id_produit = p.id
        JOIN categorie AS c ON p.id_categorie = c.id
        GROUP BY c.nom
    ";

    $result = mysqli_query($connection, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row; // Stocker les résultats dans un tableau
    }

    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse des Ventes</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Catégorie', 'Ventes Totales'],
                <?php
                foreach ($data as $row) {
                    echo "['" . $row['categorie'] . "', " . $row['ventes_totales'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Ventes Totales par Catégorie',
                hAxis: {title: 'Catégorie', textStyle: {color: '#444', fontSize: 14, fontName: 'Poppins', bold: true}},
                vAxis: {title: 'Ventes Totales', textStyle: {color: '#444', fontSize: 14, fontName: 'Poppins', bold: true}},
                chartArea: {width: '70%', height: '70%'},
                legend: {position: 'none'},
                colors: ['#4CAF50'], // Couleur du graphique (vert)
                backgroundColor: '#f9f9f9', // Fond clair pour le graphique
                fontName: 'Poppins',
                fontSize: 14
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <style>
        /* Réinitialisation des marges et des paddings */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 40px 0;
            font-size: 2.5rem;
            color: #444;
            text-transform: uppercase;
            font-weight: bold;
        }

        /* Style de la div contenant le graphique */
        #chart_div {
            width: 100%;
            height: 500px;
            max-width: 900px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        /* Mise en forme des titres de section */
        h1 {
            font-size: 2.5rem;
            color: #333;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }

            #chart_div {
                width: 100%;
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5rem;
            }

            #chart_div {
                width: 100%;
                height: 300px;
            }
        }

        /* Animation et transition */
        #chart_div {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <h1>Analyse des Ventes</h1>
    <div id="chart_div"></div>
</body>
</html>

<?php 
    } else {
        header('location: ../index.php');
    }
?>
