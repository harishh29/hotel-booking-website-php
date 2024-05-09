<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - HOME</title>
    <style>
        
        .availability-form{
          margin-top: -50px;
          z-index: 2;
          position: relative;
        }

        @media screen and (max-width: 575px){
          .availability-form{
          margin-top: 25px;
          padding: 0 35px;
        }

        }
    </style>
</head>
<body class="bg-light">

  <?php 
    require('inc/header.php');
  ?>


  
  <!-- Carousel -->
  <div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
        <?php 
        $res = selectAll('carousel');
        while($row = mysqli_fetch_assoc($res)){

            $path = CAROUSEL_IMAGE_PATH;
            echo <<<data
              <div class="swiper-slide">
                <img src="$path$row[image]" class="w-100 d-block"/>
              </div>
            data;
        }
        ?>
      </div>
    </div>
  </div>
  
  <!-- Check Room Availability -->
  <div class="container availability-form">
    <div class="row">
      <div class="col-lg-12 bg-white shadow p-4 rounded">
        <h5>Check Room Availability</h5>
        <form action="room.php">
          <div class="row align-items-end">
            <div class="col-lg-3 mb-3">
              <label class="form-label" style="font-weight: 500;" >Check-In</label>
              <input type="date" class="form-control shadow-none" name="checkin" required>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label" style="font-weight: 500;" >Check-Out</label>
              <input type="date" class="form-control shadow-none" name="checkout" required>
            </div>
            <div class="col-lg-3 mb-3">
              <label class="form-label" style="font-weight: 500;">Adult</label>
              <select class="form-select  shadow-none" aria-label="Default select example" name="adult">
                <?php
                $guests_q = mysqli_query($con, "SELECT MAX(adult) AS `max_adult`, MAX(children) AS `max_children` FROM `rooms` WHERE
                              `status` = '1' AND `removed` ='0'");
                $guest_r = mysqli_fetch_assoc($guests_q);

                for($i =1; $i <=$guest_r['max_adult']; $i++){
                  echo "<option value='$i'>$i</option>";
                }
                ?>
                
              </select>
            </div>
            <div class="col-lg-2 mb-3">
              <label class="form-label" style="font-weight: 500;">Children</label>
              <select class="form-select shadow-none" aria-label="Default select example" name="children">
                <?php
                  for($i =1; $i <=$guest_r['max_children']; $i++){
                    echo "<option value='$i'>$i</option>";
                  }
                  ?>
              </select>
            </div>
            <input type="hidden" name="check_availability">
            <div class="col-lg-1 mb-lg-3 mt-2">
              <button type="submit" class="btn text-white custom-bg shadow-none">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Rooms -->

  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Rooms</h2>

  <div class="container">
    <div class="row">

    <?php
          $room_res = select("SELECT * FROM `rooms` WHERE `status` = ? AND `removed`=? ORDER BY `id` LIMIT 3",[1,0],'ii');

          while($room_data = mysqli_fetch_assoc($room_res)){
            //get features of room

            $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f
                      INNER JOIN `room_features` rf ON f.id = rf.features_id
                      WHERE rf.room_id = '$room_data[id]'" );

            $features_data ='';

            while($fea_row = mysqli_fetch_assoc($fea_q)){
              $features_data .= "<span class='badge rounded-pill bg-light text-dark  text-wrap'>
                                $fea_row[name]
                                </span>";
            }

            //get facilities of room

            $fac_q = mysqli_query($con, "SELECT fac.name FROM `facilities` fac
                      INNER JOIN `room_facilities` rfac ON fac.id = rfac.facilities_id
                      WHERE rfac.room_id = '$room_data[id]'" );
            
            $facilities_data ='';

            while($fac_row = mysqli_fetch_assoc($fac_q)){
              $facilities_data .= "<span class='badge rounded-pill bg-light text-dark  text-wrap'>
                                  $fac_row[name]
                                  </span>";
            }

            //get thumbnail of image

            $room_thumbnail = ROOMS_IMAGE_PATH."thumbnail.jpg";

            $thumb_q = mysqli_query($con,"SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

            if(mysqli_num_rows($thumb_q)>0){
              $thumb_res = mysqli_fetch_assoc($thumb_q);
              $room_thumbnail = ROOMS_IMAGE_PATH.$thumb_res['image'];
            }

            //if website not shutdown, enable book button
            $book_btn = "";

            if(!$settings_r['shutdown']){
              $login = 0;
              if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                $login = 1;
              }
              $book_btn ="<button onclick= 'checkLoginToBook($login, $room_data[id])'   class='btn btn-sm text-white shadow-none custom-bg'>BOOK</button>";
            }

            //star for rating
            $rating_q = "SELECT ROUND(AVG(rating)) AS `avg_rating` FROM `rating_review` WHERE `room_id` = '$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20 ";

            $rating_r = mysqli_query($con,$rating_q);

            $rating_fetch = mysqli_fetch_assoc($rating_r);
            
            $rating_data = "";

            if($rating_fetch['avg_rating']!= NULL){
              $rating_data = "<div class='rating mb-4'>
                                <h6 class='mb-1'>Rating</h6>
                                <span class='badge rounded-pill bg-light'>";
              for($i=0; $i<$rating_fetch['avg_rating']; $i++){
                $rating_data .= "<i class='bi bi-star-fill text-warning ps-1'></i>";
              }
              for($i=0; $i < 5-$rating_fetch['avg_rating']; $i++){
                $rating_data .= "<i class='bi bi-star-fill text-secondary ps-1'></i>";
              }
              $rating_data .= " </span>
                              </div>";
            }



            //print room card
            echo<<<data
                  <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                      <img src="$room_thumbnail" class="card-img-top">
                        <div class="card-body">
                          <h5>$room_data[room_name]</h5>
                          <h6 class="mb-4">RM $room_data[price] per night</h6>
                          <div class="features mb-4">
                            <h6 class="mb-1">Features</h6>
                              $features_data
                          </div>
                          <div class="facilities mb-4">
                            <h6 class="mb-1">Facilities</h6>
                              $facilities_data
                            
                          </div>
                          <div class="guest mb-4">
                            <h6 class="mb-1">Guests</h6>
                            <span class="badge rounded-pill bg-light text-dark  text-wrap">
                              $room_data[adult] Adult
                            </span>
                            <span class="badge rounded-pill bg-light text-dark  text-wrap">
                              $room_data[children] Children
                            </span>
                          </div>
                          $rating_data
                          <div class="d-flex justify-content-evenly mb-2">
                          $book_btn                          
                          <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">Learn More</a>
          
                          </div>
                          
                        </div>
                    </div>
                  </div>

            data;
          }
        ?>
        
        
        <div class="col-lg-12 text-center mt-5">
          <a href="room.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Explore More</a>
        </div>
    </div>
  </div>

  <!-- facilities -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Our Facilities</h2>

  <div class="container">
    <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">

        <?php 
            $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY `id` LIMIT 4");
            $path = FEATURES_IMAGE_PATH;

            while($row = mysqli_fetch_assoc($res)){
              echo<<< data
              <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                <img src="$path$row[icon]" width="80px">
                <h5 class="mt-3">$row[name]</h5>
              </div> 
              data;
            }
        ?>
      
      <div class="col-lg-12 text-center mt-5">
        <a href="facility.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Explore More</a>
      </div>
    </div>
  </div>

  <!-- Feedback -->
  
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Feedback</h2>
  <div class="container mt-5">
    <div class="swiper swiper-feedback">
      <div class="swiper-wrapper mb-5">
          <?php
          
            $feedback_q = "SELECT rr.*, uc.name AS uname, r.room_name AS rname FROM `rating_review` rr 
                            INNER JOIN `user_cred` uc ON rr.user_id = uc.id
                            INNER JOIN `rooms` r ON rr.room_id = r.id
                            ORDER BY `sr_no` ASC LIMIT 6";
            $feedback_res = mysqli_query($con, $feedback_q);

            if(mysqli_num_rows($feedback_res)==0){
              echo 'No Reviews Yet';
            }
            else{
              while($row = mysqli_fetch_assoc($feedback_res)){
                $stars  =   "<i class='bi bi-star-fill text-warning ps-1'></i>";
                for($i = 1; $i<$row['rating']; $i++){
                  $stars .= "<i class='bi bi-star-fill text-warning ps-1'></i>";
                }

                echo <<< feedback
                <div class="swiper-slide bg-white p-4 h-auto">
                    <div class="profile d-flex align-items-center mb-3">
                      <i class="bi bi-person-circle" style="font-size: 30px;"></i>
                      <h6 class="m-0 ms-2">$row[uname]</h6>
                    </div>
                    <div class="rating mb-2">
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
      
      <div class="swiper-pagination"></div>
    </div>



  </div>

  <!-- Contact -->
  <?php 
    $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $value = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_q, $value,'i'));
  ?>

  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Contact Us</h2>

  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3">
      <iframe class="w-100" src="<?php echo $contact_r['iframe']?>" height="450"  loading="lazy"></iframe>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="bg-white p-4 my-4">
          <h5>Contact us at</h5>
          <a href="tel: +<?php echo $contact_r['phn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['phn1']?></a>
          <br>
          <?php 
            if($contact_r['phn2']!=''){
              echo<<<data
              <a href="tel: +$contact_r[phn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
              <i class="bi bi-telephone-fill"></i> +$contact_r[phn2]</a>
              <br>
              data;
            }
    
          ?>
          <a href="" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-envelope"></i> <?php echo $contact_r['email']?></a>
        </div>
        <div class="bg-white p-4 my-4">
          <h5>Follow us at</h5>
          <?php 
            if($contact_r['tw']!=''){
              echo<<<data
                <a href="$contact_r[tw]" class="d-inline-block mb-3" target="_blank">
                  <span class="badge bg-light text-dark fs-6 p-2">
                    <i class="bi bi-twitter-x"></i> Twitter
                    </span>
                </a>
                <br>
              data;
            }
            if($contact_r['ig']!=''){
              echo<<<data
                <a href="$contact_r[ig]" class="d-inline-block mb-3" target="_blank">
                  <span class="badge bg-light text-dark fs-6 p-2">
                    <i class="bi bi-instagram"></i> Instagram
                    </span>
                </a>
                <br>
              data;
            }
            if($contact_r['fb']!=''){
              echo<<<data
                <a href="$contact_r[fb]" class="d-inline-block mb-3" target="_blank">
                  <span class="badge bg-light text-dark fs-6 p-2">
                  <i class="bi bi-facebook"></i> Facebook
                    </span>
                </a>
                <br>
              data;

            }
          ?>
        </div>

      </div>
      
      
      
    </div>
  </div>
  
  <!-- Password Reset modal -->
  <div class="modal fade" id="recoveryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="resetpassword-form">
          <div class="modal-header">
            <h5 class="modal-title  d-flex align-items-center "><i class="bi bi-lock fs-3 me-2"></i>Reset Password</h5>
            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          
            <div class="mb-4">
                <label class="form-label">New password</label>
                <input type="password" name="password" class="form-control shadow-none" required >
                <input type="hidden" name="email">
                <input type="hidden" name="token">
            </div>     
            <div class="mb-2 text-end">
              <button type="button" class="btn shadow-none me-2 " data-bs-dismiss="modal">CANCEL</button>
              <button type="submit" class="btn btn-dark shadow-none">SUBMIT</button>
            </div>
          </div>
          </form>
      </div>
    </div>
  </div>


  <!-- footer -->

  <?php require('inc/footer.php'); ?>

  <?php

    if(isset($_GET['reset_password'])){
      $data = filteration($_GET);

      $t_date = date("Y-m-d");

      $query = select("SELECT * FROM `user_cred` WHERE `email` = ? AND `token`=? AND `t_expire`=? LIMIT 1", [$data['email'], $data['token'], $t_date], 'sss');

      if(mysqli_num_rows($query)==1){
        

        echo<<< showModal
        <script>
        var myModal = document.getElementById('recoveryModal');

        myModal.querySelector("input[name='email']").value = '$data[email]';
        myModal.querySelector("input[name='token']").value = '$data[token]';
        var modal = bootstrap.Modal.getOrCreateInstance(myModal);
        modal.show();
        </script>
        showModal;
      
      }
      else{
        alert("error","Invalid  or expired Link");
      }
    }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      }
    });

    var swiper = new Swiper(".swiper-feedback", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: "3",
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1280: {
          slidesPerView: 3,
        },
      }
    });

    // reset password
    let resetpass_form = document.getElementById('resetpassword-form');

    resetpass_form.addEventListener('submit', (e)=>{
      e.preventDefault();

      let data = new FormData();
      data.append('email', resetpass_form.elements['email'].value);
      data.append('token', resetpass_form.elements['token'].value);
      data.append('password', resetpass_form.elements['password'].value);

      data.append('reset_pass','');

      var myModal = document.getElementById('recoveryModal');
      var modal = bootstrap.Modal.getInstance(myModal);
      modal.hide();

      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/login_register.php", true);

      xhr.onload = function(){
        if(this.responseText == 'upd_failed'){
          alert('error', "Failed to reset password!");
        }
        else{
          alert('success', "Your password has been changed!");

          resetpass_form.reset();
        }
      }

      xhr.send(data);

    });
  </script>
</body>
</html>