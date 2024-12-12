<section class="slider_section">
  <div id="customCarousel1" class="carousel">
    <div class="carousel-inner">
      <!-- Slide 1 -->
      <div class="car active">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-12">
              <div class="detail-box">
                <h1>Bienvenue dans notre boutique</h1>
                <p>Découvrez nos produits de qualité à des prix exceptionnels.</p>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="imgBB">
                <img src="../client/images/New Specs In 2025.png" alt="Image de présentation de la boutique" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide 2 -->
      <div class="car">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-12">
              <div class="detail-box">
                <h1>Offres spéciales</h1>
                <p>Profitez de nos remises exclusives sur une large gamme de produits.</p>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="imgBB">
                <img src="../client/images/New Specs In 2025 (1).png" alt="Fond d'écran d'ordinateur" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide 3 -->
      <div class="car">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-12">
              <div class="detail-box">
                <h1>Bienvenue dans notre boutique</h1>
                <p>Une expérience de shopping en ligne simplifiée et agréable.</p>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="imgBB">
                <img src="../client/images/New Specs In 2025 (2).png" alt="Présentation de produits" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  /* Style de l'image */
  .imgBB {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
  }

  /* Style des diapositives */
  .car {
    display: none;
    transition: opacity 0.5s ease-in-out;
  }

  .car.active {
    display: block;
    height: 100%;
    width: 100%;
    opacity: 1;
    background-color: #060047;
  }

  /* Style des textes */
  .detail-box h1 {
    font-size: 2.5rem;
    font-weight: bold;
  }

  .detail-box p {
    font-size: 1.2rem;
    margin-top: 10px;
    color: #666;
  }

  /* Réactivité */
  @media (max-width: 768px) {
    .detail-box h1 {
      font-size: 1.8rem;
    }

    .detail-box p {
      font-size: 1rem;
    }

    .imgBB img {
      width: 100%; /* Ajout de cette règle pour que l'image soit responsive */
    }

    
  }

  @media (max-width: 576px) {
    .detail-box h1 {
      font-size: 1.6rem;
    }

    .detail-box p {
      font-size: 0.9rem;
    }
  }
</style>

<script>
  // JavaScript pour le défilement automatique
  document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector("#customCarousel1");
    const items = carousel.querySelectorAll(".car");
    let currentIndex = 0;

    function showNextSlide() {
      items[currentIndex].classList.remove("active");
      currentIndex = (currentIndex + 1) % items.length;
      items[currentIndex].classList.add("active");
    }

    // Défilement toutes les 4 secondes
    setInterval(showNextSlide, 4000);
  });
</script>
