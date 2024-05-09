<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - ROOMS</title>
    <style>
      .pop:hover{
        border-top-color: var(--sage-hover) !important;
        transform: scale(1.03);
        transition: all 0.3s;
      }
    </style>
</head>
<body class="bg-light">
  <!-- Header -->
  <?php require('inc/header.php');
  
    $checkin_default="";
    $checkout_default="";
    $adult_default="";
    $children_default="";

    if(isset($_GET['check_availability'])){
      $frm_data  = filteration($_GET);

      $checkin_default = $frm_data['checkin'];
      $checkout_default = $frm_data['checkout'];
      $adult_default= $frm_data['adult'];
      $children_default= $frm_data['children'];
  }
  ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOMS</h2>
    <div class="h-line bg-dark"></div>
  </div>

  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4">
        <nav class="navbar navbar-expand-lg  navbar-light bg-white rounded shadow">
          <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2">Filters</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
              <!-- Check Room Availability -->
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px">
                  <span>Check Availabity</span>
                  <button id="vac-reset-btn" class="btn btn-sm text-secondary shadow-none d-none" onclick="room_vac_clear()">Reset</button>
                </h5>
                <label class="form-label" style="font-weight: 500;" >Check-In</label>
                <input type="date" class="form-control shadow-none mb-3" value="<?php echo $checkin_default ?>" id="checkin" onchange="room_vac_filter()">
                <label class="form-label" style="font-weight: 500;" >Check-Out</label>
                <input type="date" class="form-control shadow-none mb-3" value="<?php echo $checkout_default ?>" id="checkout" onchange="room_vac_filter()">
              </div>
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px">
                    <span>FACILITIES</span>
                    <button id="facility-btn" class="btn btn-sm text-secondary shadow-none d-none" onclick="facility_btn_clear()">Reset</button>
                </h5>
                <?php
                  $facilities_q = selectAll('facilities');
                  while($row =mysqli_fetch_assoc($facilities_q)){
                    echo<<< facilities
                          <div class="mb-2">
                            <input type="checkbox" onclick="fetch_rooms()" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1">
                            <label for="$row[id]" class="form-check-label">$row[name]</label>
                          </div>
                    facilities;
                  }
                ?>
              </div>

              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px">
                  <span>Guest</span>
                  <button id="guest-btn" class="btn btn-sm text-secondary shadow-none d-none" onclick="guest_btn_clear()">Reset</button>
                </h5>
                <div class="d-flex">
                  <div class="me-2">
                    <label for="" class="form-label">Adult</label>
                    <input type="number" min="1"  id="adult" value="<?php echo $adult_default ?>" oninput="guest_filter()" class="form-control shadow-none">
                  </div>
                  <div>
                    <label for="" class="form-label">Children</label>
                    <input type="number" min="0"  id="children"value="<?php echo $children_default ?>"  oninput="guest_filter()" class="form-control shadow-none">
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </nav>
      </div>

      <div class="col-lg-9 col-md-12 px-4" id="rooms-data">

      </div>
    </div>
  </div>

  <script>

    let rooms_data = document.getElementById('rooms-data');

    let checkin = document.getElementById('checkin');
    let checkout = document.getElementById('checkout');
    let vac_reset_btn = document.getElementById('vac-reset-btn');

    let adult = document.getElementById('adult');
    let children = document.getElementById('children');
    let guest_btn  = document.getElementById('guest-btn');

    let facilities_btn  = document.getElementById('facility-btn');

    function fetch_rooms(){
      let room_vac  = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
      } );

      let guests  = JSON.stringify({
        adult: adult.value,
        children: children.value
      } );
      
      let facility_list = {"facilities":[]};

      let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
      if(get_facilities.length>0){
        get_facilities.forEach((facility)=>{
          facility_list.facilities.push(facility.value);
        })
        facilities_btn.classList.remove('d-none');
      }
      else{
        facilities_btn.classList.add('d-none');
      }

      facility_list = JSON.stringify(facility_list);

      let xhr = new XMLHttpRequest();
      xhr.open("GET", "ajax/rooms.php?fetch_rooms&room_vac="+room_vac+"&guests="+guests+"&facility_list="+ facility_list, true);

      xhr.onprogress = function(){

        //spinner if page load slowly
        rooms_data.innerHTML = `<div class="spinner-border text-secondary  mb-3 d-block mx-auto" id ="loader" role="status">
                                  <span class="visually-hidden">Loading...</span>
                                </div>`;

      }
      xhr.onload = function(){
        rooms_data.innerHTML = this.responseText;
      }

      xhr.send();
    }

    function room_vac_filter(){
      if(checkin.value != '' && checkout.value !=''){
        fetch_rooms();
        vac_reset_btn.classList.remove('d-none');
      }
    }

    function room_vac_clear(){
        checkin.value = '';
        checkout.value = '';

        vac_reset_btn.classList.add('d-none');
        fetch_rooms();
      
    }

    function guest_filter(){
      if(adult.value > 0 && children.value >= 0 ){
        fetch_rooms();
        guest_btn.classList.remove('d-none');
      }
    }

    function guest_btn_clear(){
      adult.value='';
      children.value='';

      guest_btn.classList.add('d-none');
      fetch_rooms();
    }

    function facility_btn_clear(){
      let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
      get_facilities.forEach((facility)=>{
        facility.checked = false;
      });
      facilities_btn.classList.add('d-none');

      fetch_rooms();
      
    }

    window.onload = function(){
      fetch_rooms();
    }
    
    
  </script>

  
  <!-- footer -->

  <?php require('inc/footer.php')?>

  
</body>
</html>