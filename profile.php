<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('inc/links.php')?>
    <link rel="stylesheet" href="css/common.css">
    <title><?php echo $settings_r['site_title']?> - PROFILE</title>
    
</head>
<body class="bg-light">
  <!-- Header -->
  <?php 
    require('inc/header.php');

    if(!(isset($_SESSION['login']) && $_SESSION['login'] == true)){
      redirect('index.php');
    }
    $q ="SELECT * FROM `user_cred` WHERE id= ? LIMIT 1";

    $res = select($q, [$_SESSION['uID']],'s');

    if(mysqli_num_rows($res)==0){
      redirect('index.php');
    }

    $user_r = mysqli_fetch_assoc($res);
    
  ?>

  


  <div class="container">
    <div class="row ">
      
      <div class="col-12 my-5 mb-5 px-4">
        <h2 class="fw-bold"><?php echo $user_r['name'] ?>'s PROFILE</h2>
        <div style="font-size: 14px;">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary">></span>
          <a href="profile.php" class="text-secondary text-decoration-none">PROFILE</a>
        </div>
      </div>
    
      <!-- Edit Profile -->
      <div class="col-12 mb-5 px-4">
        <div class="bg-white p-3 p-md-4 rounded shadow-sm">
          <form id="profile-form">
            <h5 class="mb-3 fw-bold">My Profile</h5>
              <div class="row">
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Name</label>
                  <input name="name" type="text" value="<?php echo $user_r['name']?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Email</label>
                  <input name="email" type="email" value="<?php echo $user_r['email']?>" class="form-control shadow-none" disabled>
                </div>
                <div class="col-md-6 ps-0 mb-3">
                  <label class="form-label">Phone Number</label>
                  <input name="phone_number" type="number" value="<?php echo $user_r['phone_number']?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 p-0 mb-3">
                  <label class="form-label">Date of Birth</label>
                  <input name="date_of_birth" type="date" value="<?php echo $user_r['date_of_birth']?>" class="form-control shadow-none" required>
                </div>
                <div class="col-md-8 ps-0 mb-3">
                  <label class="form-label">Address</label>
                  <textarea name="address" id=""  rows="1"  class="form-control shadow-none" required><?php echo $user_r['address']?></textarea>
                </div>
                <div class="col-md-4 p-0 mb-3">
                  <label class="form-label">Pincode</label>
                  <input name="pincode" type="text" value="<?php echo $user_r['pincode']?>" class="form-control shadow-none" required>
                </div>
              </div>
              <div class="d-flex justify-content-center">              
                <button type="submit" class="btn text-white shadow-none custom-bg ">Save Changes</button>
              </div>
          </form>
        </div>
      </div>

      <!-- Change Password -->
      <div class="col-12 mb-5  d-flex justify-content-center">
        <div class="bg-white p-3 p-md-4 rounded shadow-sm ">
          <form action="" id="pass-form">
            <h5 class="mb-3 fw-bold">Change Password</h5>
            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="" class="form-label">New Password</label>
                <input name="password" type="password" class="form-control shadow-none">
              </div>
              <div class="col-md-6 mb-4">
                <label for="" class="form-label">Confirm Password</label>
                <input name="password_confirm" type="password" class="form-control shadow-none">
              </div>
            </div>
            <div class="d-flex justify-content-center">              
                <button type="submit" class="btn text-white shadow-none custom-bg ">Save Changes</button>
            </div>
          </form>
        </div>
      </div>

      

      

    </div>
  </div>

  

  
  <!-- footer -->

  <?php require('inc/footer.php')?>
  
  <script>
    let profile_form = document.getElementById('profile-form');

    profile_form.addEventListener('submit',function(e){
      e.preventDefault();
      
      let data = new FormData();
      data.append('profile_form','');
      data.append('name',profile_form.elements['name'].value);
      data.append('email',profile_form.elements['email'].value);
      data.append('phone_number',profile_form.elements['phone_number'].value);
      data.append('date_of_birth',profile_form.elements['date_of_birth'].value);
      data.append('address',profile_form.elements['address'].value);
      data.append('pincode',profile_form.elements['pincode'].value);
      
      
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/profile.php", true);
      
  
      xhr.onload = function(){
        if(this.responseText=='phone_already'){
          alert('error',"Phone Number is already registered");
        }
        else if(this.responseText == 0){
          alert('error', "No Changes Made!");
        }
        else{
          alert('success',"Changes Saved!");
        }
        
      }
      xhr.send(data);
    });

    let pass_form = document.getElementById('pass-form');

    pass_form.addEventListener('submit',function(e){
      e.preventDefault();
      let new_password = pass_form.elements['password'].value;
      let confirm_password = pass_form.elements['password_confirm'].value;

      if(new_password != confirm_password){
        alert('error', 'Password does not match!');
        return false;
      }
      
      let data = new FormData();
      data.append('pass_form','');
      data.append('password',new_password);
      data.append('password_confirm',confirm_password);
     
      
      
      let xhr = new XMLHttpRequest();
      xhr.open("POST", "ajax/profile.php", true);
      
  
      xhr.onload = function(){
        if(this.responseText=='mismatch'){
          alert('error',"Password does not match!");
        }
        else if(this.responseText == 0){
          alert('error', "Failed to update password!");
        }
        else{
          alert('success',"Password Updated!");
          pass_form.reset();
        }
        
      }
      xhr.send(data);
    });

      



  </script>

  
</body>
</html>
