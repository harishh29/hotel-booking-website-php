<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - CONFIRM BOOKING</title>
    
</head>
<body class="bg-light">
  <!-- Header -->
  <?php require('inc/header.php');?>

  <?php

    // check room id from url is present or not
    // website is offline or online
    // users is logged in or not


    if(!isset($_GET['id']) || $settings_r['shutdown']== true){
      redirect('room.php');
    }
    elseif(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
      redirect('room.php');

    }
    
    // filter and get room and user data
    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `id` =? AND `status` = ? AND `removed`=?",[$data['id'], 1,0],'iii');

    if(mysqli_num_rows($room_res)==0){
      redirect('room.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $_SESSION['room'] = [
      "id" => $room_data['id'],
      "room_name" => $room_data['room_name'],
      "price" => $room_data['price'],
      "payment" => null,
      "available" => null
    ];

    $user_res = select("SELECT * FROM `user_cred` WHERE `id` = ? LIMIT 1", [$_SESSION['uID']],'i');
    $user_data = mysqli_fetch_assoc($user_res);

  ?>


  <div class="container-fluid">
    <div class="row ">
      
      <div class="col-12 my-5 mb-5 px-4">
        <h2 class="fw-bold">CONFIRM BOOKING - <?php echo $room_data['room_name'] ?></h2>
        <div style="font-size: 14px;">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary">></span>
          <a href="room.php" class="text-secondary text-decoration-none">ROOMS</a>
          <span class="text-secondary">></span>
          <a href="room.php" class="text-secondary text-decoration-none">BOOKING</a>
        </div>
      </div>

      <div class="col-lg-7 col-md-12 px-4 mb-3">
          <?php

          $room_thumbnail = ROOMS_IMAGE_PATH."thumbnail.jpg";

          $thumb_q = mysqli_query($con,"SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

          if(mysqli_num_rows($thumb_q)>0){
            $thumb_res = mysqli_fetch_assoc($thumb_q);
            $room_thumbnail = ROOMS_IMAGE_PATH.$thumb_res['image'];
          }
          
          echo <<< data
            <div class = "card p-3 shadow-sm rounded " >
              <img src="$room_thumbnail" class="img-fluid rounded mb-3">
              <h5>$room_data[room_name]</h5>
              <h5>RM $room_data[price]</h5>
            </div>
          data;

          ?>
      </div>

      <div class="col-lg-5 col-md-12 px-4">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
          <div class="card-body">
            <form action="confirm_booking.php" method="POST" id="booking_form">
              <h6 class="mb-3">BOOKING DETAILS</h6>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Name</label>
                  <input name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Mobile no.</label>
                  <input name="phone_number" type="number" value="<?php echo $user_data['phone_number'] ?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-12 mb-3">
                  <label for="" class="form-label">Address</label>
                  <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address'] ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Check-In</label>
                  <input name="checkin" onchange="checkAvailability()" type="date" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Check-Out</label>
                  <input name="checkout" onchange="checkAvailability()" type="date" class="form-control shadow-none" required>
                </div>
                <div class="col-12">
                  <div class="spinner-border text-secondary  mb-3 d-none" id ="info_loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                    <h6 class="mb-3 text-danger" id="pay_info">Kindly provide a date for your booking!</h6>
                    <button type="submit" class="btn w-100 text-white custom-bg shadow-none mb-3" id="pay_now">
                      Pay Now
                    </button>
                </div>
              </div>
            </form>
            <div id="book-link" class = "card p-3 shadow-sm rounded bg-success d-none " >
              <h5 class="text-white mb-1">Payment Done! Booking Successful!</h5>
              <a  class="text-white " href="booking.php"> Go to Bookings <span class="text-white">>></span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <!-- footer -->

  <?php require('inc/footer.php')?>
  <script>
    let booking_form = document.getElementById('booking_form');
    let info_loader = document.getElementById('info_loader');
    let pay_info = document.getElementById('pay_info');

    function checkAvailability(){
      let checkin_val = booking_form.elements['checkin'].value;
      let checkout_val = booking_form.elements['checkout'].value;
      
      booking_form.elements['pay_now'].setAttribute('disabled',true);

      if(checkin_val !='' && checkout_val!=''){
        pay_info.classList.add('d-none');
        pay_info.classList.replace('text-dark', 'text-danger');
        info_loader.classList.remove('d-none');


        let data  = new FormData();
        data.append('checkAvailability', '');
        data.append('checkin',checkin_val);
        data.append('checkout',checkout_val);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/confirm_booking.php", true);

        xhr.onload = function(){
         let data  = JSON.parse(this.responseText);

         if(data.status == 'check_in_out_equal'){
          pay_info.innerText = "You cannot check-out on the same day";
         }
         else if(data.status == 'check_out_earlier'){
          pay_info.innerText = "Check out date is earlier than check in date!";
         }
         else if(data.status == 'check_in_earlier'){
          pay_info.innerText = "You cannot book for past date!";
         }
         else if(data.status == 'unavailable'){
          pay_info.innerText = "Sorry! No room vacancy during this period!";
         }
         else{
          pay_info.innerHTML= "No. of Days: "+data.days+"<br>Amount Total: RM "+data.payment;
          pay_info.classList.replace('text-danger','text-dark');
          booking_form.elements['pay_now'].removeAttribute('disabled');
         }

         pay_info.classList.remove('d-none');
         info_loader.classList.add('d-none');

        }
        xhr.send(data);
      }
    }

    let book_link = document.getElementById('book-link');

    booking_form.addEventListener('submit', (e)=>{
      e.preventDefault();

      let data = new FormData();

      data.append('name', booking_form.elements['name'].value);
      data.append('phone_number', booking_form.elements['phone_number'].value);
      data.append('address', booking_form.elements['address'].value);
      data.append('checkin', booking_form.elements['checkin'].value);
      data.append('checkout', booking_form.elements['checkout'].value);
      data.append('booking_order','');
    
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/pay_now.php", true);

      xhr.onload = function(){
        // alert('success', "Payment Successful! Go to Bookings to see update!");
        booking_form.reset();
        book_link.classList.remove('d-none');
        

      }
      
      xhr.send(data);

    });

  </script>

  
</body>
</html>
