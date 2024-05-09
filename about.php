<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - ABOUT</title>
    <style>
      .box{
        border-top-color: var(--sage-hover)!important;
      }
    </style>
    
</head>
<body class="bg-light">
  <!-- Header -->
  <?php require('inc/header.php')?>


  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">ABOUT US</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
      Welcome to Kafka Hotel, where luxury meets comfort in the heart of Malaysia. 
      Nestled amidst scenic landscapes,<br> vibrant beach, and Asian hospitality,
       our hotel is the epitome of elegance and sophistication.
    </p>
  </div>

  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
        <p> With a rich history spanning 10+ years, we pride ourselves on delivering 
          unparalleled hospitality and exceptional service to each and every guest. Whether 
          you're here for business or leisure, our dedicated team is committed to ensuring 
          that your stay with us is nothing short of memorable. From our meticulously designed 
          rooms and suites to our world-class amenities and culinary offerings, every aspect of your 
          experience has been thoughtfully curated to exceed your expectations. Discover the perfect 
          blend of relaxation and excitement at Kafka Hotel, where every moment 
          is crafted with care to create unforgettable memories.</p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-2  order-md-2 order-1">
        <img src="img/about/about1.jpg" class="w-100">
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="img/features/wifi.svg" width="70px" alt="">
        <h4 class="mt-3">100+ ROOMS</h4>
        </div>  
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="img/features/wifi.svg" width="70px" alt="">
        <h4 class="mt-3">2.5K REVIEWS</h4>
        </div>  
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="img/features/wifi.svg" width="70px" alt="">
        <h4 class="mt-3">200+ STAFF</h4>
        </div>  
      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
        <img src="img/features/wifi.svg" width="70px" alt="">
        <h4 class="mt-3">10+ YEAR</h4>
        </div>  
      </div>
    </div>
  </div>

  <div class="container px-4">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper my-5 ">
        <?php 
          $about_r = selectAll('team');
          $path = ABOUT_IMAGE_PATH;

          while($row = mysqli_fetch_assoc($about_r)){

            echo<<<data
            <div class="swiper-slide bg-white text-center overflow-hidden rounded">
              <img src="$path$row[picture]" class="w-100">
              <h5 class="mt-2">$row[name]</h5>
            </div>
            data;
          }
        
        
        ?>
      
      </div>  
      <div class="swiper-pagination"></div>
    </div>
  </div>
  
  <!-- footer -->

  <?php require('inc/footer.php')?>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 3,
    spaceBetween: 30,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 3,
        },
        1280: {
          slidesPerView: 3,
        },
      }
  });
</script>

  
</body>
</html>