<?php 
session_start();
include('../include/connection.php');
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <link rel="icon" href="../client/images/fevicon.png" type="image/gif" />

  <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
  <link rel="stylesheet" href="/css/navclinent.css">
  <link rel="stylesheet" href="/css/homeC.css">
  <link rel="stylesheet" href="/css/scripte/produit.js">

  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>BTK-Tech</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../client/css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet"> <!-- range slider -->

  <!-- font awesome style -->
  <link href="../client/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../client/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../client/css/responsive.css" rel="stylesheet" />

</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="header_top">
        <div class="container-fluid">
          <div class="top_nav_container">
            <div class="contact_nav">
              <a href="">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>
                  Tlf : 0783962348
                </span>
              </a>
              <a href="">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <span>
                  Email : mohammed.betkaoui@univ-bba.dz
                </span>
              </a>
            </div>
           
            <div class="user_option_box">
                <?php if(isset($_SESSION['id_c'])){ ?>
                
              <a href="./profile.php" class="account-link">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>
                  <?php echo $_SESSION['nom_c'];?>
                </span>
              </a> 
              <a href="../intrface/panier.php" class="cart-link">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>

                <?php 
                  $id_c=$_SESSION['id_c'] ;
                  if(!isset($_SESSION['panier'][$id_c])){
                    $_SESSION['panier'][$id_c][]=[];
                  }
                ?>
                <span>
                  Panier(<?php echo count($_SESSION['panier'][$id_c])-1?>)
                </span>
              </a>
              <?php } ?>
              
              <?php if(isset($_SESSION['id_a'])){ ?>
                <a href="../intrface/admin/home.php">
                  Admin | <?php echo $_SESSION['nom_a']; ?><br>
                </a>
              <?php }elseif(isset($_SESSION['id'])){ ?>
                <a href="../intrface/admin/home.php">
                  Admin | <?php echo $_SESSION['nom']; ?><br>
                </a>
              <?php } ?>
                
            </div>
          </div>

        </div>
      </div>
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="./homeClient.php">
              <span>
                <img width="20" height="20" src="/client/images/fevicon.png" alt="logo"> BTK-Tech
              </span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ">
                <li class="nav-item active">
                  <a class="nav-link" href="../intrface/homeClient.php">Accueil </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/intrface/categorie.php">Catégories</a>
                </li>
                <?php if($_SESSION){ ?>
                <li class="nav-item">
                  <a class="nav-link" href="/php/logout.php">Se déconnecter</a>
                </li>
                <?php }else{ ?>
                <li class="nav-item">
                  <a class="nav-link" href="../intrface/index.php">Se connecter</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../intrface/inscription.php">S'inscrire</a>
                </li>
                <?php }?>
              </ul>

              <!-- Search bar -->
              <form class="search-bar" action="search.php" method="GET">
                <input type="text" name="query" placeholder="Recherche...">
              </form>
            </div>
          </nav>
        </div>
      </div>
    </header>


</body>
</html>
