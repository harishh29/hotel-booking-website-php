<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - CONTACT</title>
    
</head>
<body class="bg-light">
  <!-- Header -->
  <?php require('inc/header.php')?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">CONTACT US</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
    If you have any questions or would like to know more about Kafka Hotel,<br> we invite you to see our Frequently Asked Questions or simply contact us.
    </p>
  </div>

  <!-- Contact -->
  <?php 
    $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $value = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_q, $value,'i'));
  ?>

  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4">
        <iframe class="w-100 rounded mb-4" src="<?php echo $contact_r['iframe'] ?>" height="450"  loading="lazy"></iframe>
          <h5>Address</h5>  
          <a href="<?php echo $contact_r['gmap'] ?>" target="_blank" class="d-inline-block text-decoration-none text-dark mb-2">
          <i class="bi bi-geo-alt-fill"></i> <?php echo $contact_r['address'] ?></a>
          <h5 class="mt-4">Contact us at</h5>
          <a href="tel: +$contact_r[phn1]" class="d-inline-block mb-2 text-decoration-none text-dark">
          <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['phn1'] ?></a>
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
          <i class="bi bi-envelope"></i> <?php echo $contact_r['email'] ?></a>
          <h5 class="mt-4">Follow us at</h5>
          <a href="<?php echo $contact_r['tw']?>" target="_blank" class="d-inline-block mb-3 text-dark fs-5 me-2">
              <i class="bi bi-twitter-x"></i>
          </a>
          
          <a href="<?php echo $contact_r['ig']?>" target="_blank" class="d-inline-block mb-3 text-dark fs-5 me-2">
            <i class="bi bi-instagram"></i>
          </a>
          
          <a href="<?php echo $contact_r['fb']?>" target="_blank" class="d-inline-block mb-3 text-dark fs-5 me-2">
            <i class="bi bi-facebook"></i>
          </a>

        </div>
        
      </div>

      <!-- User Queries -->
      <div class="col-lg-6 col-md-6 px-4">
        <div class="bg-white rounded shadow p-4">
          <form method="POST">
            <h5>Send a Message</h5>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500;">Name</label>
              <input name="name" required type="text" class="form-control shadow-none">
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500;">Email</label>
              <input name="email" required type="email" class="form-control shadow-none">
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500;">Subject</label>
              <input name="subject" required type="text" class="form-control shadow-none">
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight: 500;">Message</label>
              <textarea name="message" required class="form-control shadow-none" rows="5" style="resize: none;"></textarea>
            </div>
            <button type="submit" name="send" class="btn text-white custom-bg mt-3" >
              Send
            </button>
          </form>
        </div>
        
      </div>
      
    </div>
  </div>

  <?php 

      if(isset($_POST['send'])){
        $frm_data = filteration($_POST);
        $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];

        $res = insert($q, $values, 'ssss');
        if($res == 1){
          alert('success', 'Message has been sent!');
        }
        else{
          alert('error', 'Failed to send message! Try again!');
        }
      }
  ?>

  
  <!-- footer -->

  <?php require('inc/footer.php')?>

  
</body>
</html>