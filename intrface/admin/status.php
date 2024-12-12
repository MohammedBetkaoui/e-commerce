<?php
include('../../include/nav.php');  
include('../../include/connection.php');
echo '<br /><br />';

if (isset($_SESSION['id']) || isset($_SESSION['id_a'])) { 
    // Requête SQL pour récupérer les commandes par statut
    $sql = "
        SELECT status, COUNT(*) AS total
        FROM commandes
        GROUP BY status
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyse des Commandes</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        h1 {
            font-size: 28px;
            color: #444;
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        h1::after {
            content: '';
            width: 60px;
            height: 3px;
            background-color: #4CAF50;
            display: block;
            margin: 10px auto;
            border-radius: 2px;
        }

        #chart_div {
            width: 100%;
            max-width: 850px;
            height: 500px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        footer {
            margin-top: 40px;
            font-size: 14px;
            color: #888;
            text-align: center;
        }

        footer a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Animation for chart appearance */
        #chart_div {
            animation: fadeIn 1.5s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            h1 {
                font-size: 24px;
            }

            #chart_div {
                height: 400px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 22px;
            }

            #chart_div {
                height: 350px;
            }
        }
    </style>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Statut', 'Nombre de Commandes'],
                <?php
                foreach ($data as $row) {
                    echo "['" . $row['status'] . "', " . $row['total'] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Répartition des Commandes par Statut',
                titleTextStyle: {
                    fontSize: 20,
                    bold: true,
                    color: '#333',
                    fontName: 'Roboto',
                },
                backgroundColor: '#fff',
                is3D: true,
                pieSliceTextStyle: {
                    fontSize: 16,
                    color: '#fff',
                },
                pieSliceBorderColor: '#eef2f3',
                slices: {
                    0: { color: '#4caf50' }, // Livré
                    1: { color: '#f44336' }, // Annulé
                    2: { color: '#ff9800' }, // En cours
                },
                chartArea: {
                    width: '85%',
                    height: '75%',
                },
                legend: {
                    position: 'bottom',
                    textStyle: {
                        fontSize: 14,
                        color: '#555',
                    },
                },
                tooltip: {
                    showColorCode: true,
                    textStyle: {
                        fontSize: 13,
                        color: '#333',
                    },
                },
                animation: {
                    startup: true,
                    duration: 1200,
                    easing: 'out',
                },
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <h1>Répartition des Commandes</h1>
    <div id="chart_div"></div>

    <footer>
        <p>&copy; 2024 <a href="#">VotreEntreprise</a>. Tous droits réservés.</p>
    </footer>
</body>
</html>
<?php 
} else {
    header('location: ../index.php');
}
?>
