<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - ROOM DETAILS</title>
    
</head>
<body class="bg-light">
  <!-- Header -->
  <?php require('inc/header.php')?>

  <?php
    if(!isset($_GET['id'])){
      redirect('room.php');
    }
    
    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `id` =? AND `status` = ? AND `removed`=?",[$data['id'], 1,0],'iii');

    if(mysqli_num_rows($room_res)==0){
      redirect('room.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);

  ?>

  <div class="container">
    <div class="row">
      
      <div class="col-12 my-5 mb-5 px-4">
        <h2 class="fw-bold"><?php echo $room_data['room_name'] ?></h2>
        <div style="font-size: 14px;">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary">></span>
          <a href="room.php" class="text-secondary text-decoration-none">ROOMS</a>
        </div>
      </div>

      <div class="col-lg-7 col-md-12 px-4 mb-3">
          <div id="roomCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <?php 
                // get thumbnail of image

                $room_img= ROOMS_IMAGE_PATH."thumbnail.jpg";

                $img_q = mysqli_query($con,"SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]'");

                if(mysqli_num_rows($img_q)>0){
                  $active_class= 'active';

                  while($img_res = mysqli_fetch_assoc($img_q)){
                    echo "<div class='carousel-item $active_class'>
                            <img class='d-block w-100 rounded' src='".ROOMS_IMAGE_PATH.$img_res['image']."'>
                          </div>";
                    $active_class='';
                  }
                }
                else{
                  echo "<div class='carousel-item active '>
                          <img class='d-block w-100 rounded' src='$room_img' >
                        </div>";
                }
              ?>
              
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
      </div>

      <div class="col-lg-5 col-md-12 px-4">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
          <div class="card-body">
            <?php
              //price 
              echo<<<price
              <h4>RM $room_data[price] per night</h4>
              price;
              
              //star for rating
              $rating_q = "SELECT ROUND(AVG(rating)) AS `avg_rating` FROM `rating_review` WHERE `room_id` = '$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20 ";

              $rating_r = mysqli_query($con,$rating_q);
  
              $rating_fetch = mysqli_fetch_assoc($rating_r);
              
              $rating_data = "";

              if($rating_fetch['avg_rating']!= NULL){
                $rating_data = "<div class='rating mb-3'>";

                for($i=0; $i<$rating_fetch['avg_rating']; $i++){
                  $rating_data .= "<i class='bi bi-star-fill text-warning ps-1'></i>";
                }

                for($i=0; $i < 5-$rating_fetch['avg_rating']; $i++){
                  $rating_data .= "<i class='bi bi-star-fill text-secondary ps-1'></i>";
                }
                $rating_data .= "</div>";
              }

              echo<<<rating
              $rating_data
              rating;
              
              //features
              $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f
                      INNER JOIN `room_features` rf ON f.id = rf.features_id
                      WHERE rf.room_id = '$room_data[id]'" );

              $features_data ='';

              while($fea_row = mysqli_fetch_assoc($fea_q)){
                $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                  $fea_row[name]
                                  </span>";
              }

              echo <<< features
              <div class="features mb-3">
                  <h6 class="mb-1">Features</h6>
                    $features_data
              </div>
              features;

              //facilities
              $fac_q = mysqli_query($con, "SELECT fac.name FROM `facilities` fac
                       INNER JOIN `room_facilities` rfac ON fac.id = rfac.facilities_id
                       WHERE rfac.room_id = '$room_data[id]'" );
            
              $facilities_data ='';

              while($fac_row = mysqli_fetch_assoc($fac_q)){
                $facilities_data .= "<span class='badge rounded-pill bg-light text-dark  text-wrap me-1 mb-1'>
                                    $fac_row[name]
                                    </span>";
              }

              echo <<< facilities
              <div class="features mb-3">
                  <h6 class="mb-1">Features</h6>
                    $facilities_data
              </div>
              facilities;

              //number of guest
              echo<<<guest
              <div class="mb-3"">
                  <h6 class="mb-1">Guests</h6>
                    <span class="badge rounded-pill bg-light text-dark  text-wrap me-1 mb-1">
                      $room_data[adult] Adult
                    </span>
                    <span class="badge rounded-pill bg-light text-dark  text-wrap me-1 mb-1">
                    $room_data[children] Children
                  </span>
               </div>
              guest;

              // room size
              echo <<< area
              <div class="mb-3">
                  <h6 class="mb-1">Size</h6>
                  <span class='badge rounded-pill bg-light text-dark  text-wrap me-1 mb-1'>
                      $room_data[area] m<sup>3</sup>
                  </span> 
              </div>
              area;

              //if website not shutdown, enable book button
            $book_btn = "";

            if(!$settings_r['shutdown']){
              $login = 0;
              if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                $login = 1;
              }
              $book_btn ="<button onclick= 'checkLoginToBook($login, $room_data[id])'   class='btn  text-white custom-bg shadow-none w-100 mb-2'>Book Now</button>";
            }
              echo<<<book
                $book_btn
              book;
            ?>
          </div>
        </div>
      </div>

      <div class="col-12 mt-4 px-4">
        <div class="mb-4">
          <h5>Description</h5>
          <?php
          echo $room_data['description'];
          ?>
        </div>
      </div>

      <div class="px-4">
            <div class="mb-4">
              <h5 class="mb-3">Reviews & Rating</h5>

              <?php
              $feedback_q = "SELECT rr.*, uc.name AS uname, r.room_name AS rname FROM `rating_review` rr 
                              INNER JOIN `user_cred` uc ON rr.user_id = uc.id
                              INNER JOIN `rooms` r ON rr.room_id = r.id
                              WHERE rr.room_id = $room_data[id]
                              ORDER BY `sr_no` DESC LIMIT 3";
              $feedback_res = mysqli_query($con, $feedback_q);

              if(mysqli_num_rows($feedback_res)==0){
              echo 'No Reviews Yet';
              }
              else{
                while($row = mysqli_fetch_assoc($feedback_res)){

                  $stars = "";
  
                  if($row['rating']!= NULL){
                    
                    for($i=0; $i<$row['rating']; $i++){
                      $stars .= "<i class='bi bi-star-fill text-warning ps-1'></i>";
                    }

                    for($i=0; $i < 5-$row['rating']; $i++){
                      $stars .= "<i class='bi bi-star-fill text-secondary ps-1'></i>";
                    }
                  }
                  echo<<<feedback
                    <div class="mb-4">
                      <div class=" d-flex align-items-center mb-2">
                        <i class="bi bi-person-circle" style="font-size: 30px;"></i>
                        <h6 class="m-0 ms-2">$row[uname]</h6>
                      </div>
                      <div class="rating">
                      $stars
                      </div>
                      <p>
                        $row[review]
                      </p>
                    </div>
                  feedback;
                }
              }
              ?>
                
            </div>
      </div>

    </div>
  </div>

  <!-- footer -->

  <?php require('inc/footer.php')?>

</body>
</html>
