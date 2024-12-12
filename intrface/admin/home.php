
<title>Accueil</title>

<?php 
    
session_start();
if (!isset($_SESSION['id'])){
	header('../homeClient.php');

}

include('../../include/nav.php');
?>
<br>
<br>
<br>
   <header class="header_area">
		<div class="main_menu">
			
		</div>
	</header>
	<!--================ End Header Area =================-->

	<!--================ Start Home Banner Area =================-->
	<section class="home_banner_area">
		<div class="banner_inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-7">
						<br><br><br><br>
						<div class="banner_content">
							<h3 class="text-uppercase">Admin</h3>
							<br>
							<?php if(isset($_SESSION['id'])){?>
							<h4  class="text-uppercase"><?php echo $_SESSION['nom'].' '.$_SESSION['prenom']?></h1>
							<?php }?>
							<?php if(isset($_SESSION['id_a'])){?>
							<h4 class="text-uppercase" ><?php echo $_SESSION['nom_a'].' '.$_SESSION['prenom_a']?></h1>
							<?php }?>
							<h4 class="text-uppercase">bienvenue dans votre espace</h1>
							
							<div class="d-flex align-items-center">
								
							</div>
						</div>
					</div>
					<div class="col-lg-5">
						<div class="home_right_img">
							<img class="" src="/css/home/img/banner/home-right.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================ End Home Banner Area =================-->

	<!--================ Start About Us Area =================-->

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	
	
</body>

</html>