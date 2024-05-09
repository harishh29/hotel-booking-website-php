<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<?php 
  session_start();
  
  require('admin/inc/db_config.php');
  require('admin/inc/essentials.php');
  date_default_timezone_set("Asia/Kuala_Lumpur");

  $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
  $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
  
  $value = [1];
  $contact_r = mysqli_fetch_assoc(select($contact_q, $value,'i'));
  $settings_r = mysqli_fetch_assoc(select($settings_q, $value,'i'));
  
  if($settings_r['shutdown']){
    echo<<<alertBar
      <div class='bg-danger text-center p-2 fw-bold'>
      <i class="bi bi-info-circle-fill"></i>  Bookings are temporarily closed! We are sorry for any inconveniences!
      </div>
    alertBar;
  }

?>