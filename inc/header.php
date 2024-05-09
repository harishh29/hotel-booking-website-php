
<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title']?> </a>
    <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link me-2" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="room.php">Rooms</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="facility.php">Facilities</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="contact.php">Contact Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link me-2" href="about.php">About</a>
        </li>
        
      </ul>
      <div class="d-flex">
        
        <?php
          if(isset($_SESSION['login']) && $_SESSION['login'] == true){
            
            echo<<<data
              <div class="btn-group">
                <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                  $_SESSION[uName]
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end">
                  <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                  <li><a class="dropdown-item" href="booking.php">Bookings</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </div>
            data;

            // $path = USER_IMAGE_PATH;
            // echo<<<data
            //   <div class="btn-group">
            //     <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            //       <img src="$path$_SESSION[uProfilePic]" style="width: 25px; height: 25px;" class="me-1">
            //       $_SESSION[uName]
            //     </button>
            //     <ul class="dropdown-menu dropdown-menu-lg-end">
            //       <li><button class="dropdown-item" type="button">Action</button></li>
            //       <li><button class="dropdown-item" type="button">Another action</button></li>
            //       <li><button class="dropdown-item" type="button">Something else here</button></li>
            //     </ul>
            //   </div>
            // data;
          }
          else{
            echo<<<data
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
              Login
              </button>
              <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
              Register
              </button>
            data;
          }      
        ?>
        
        
      </div>
    </div>
  </div>
</nav>

  <!-- Modal -->
        <!-- Modal Login -->
  <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="login-form">
          <div class="modal-header">
            <h5 class="modal-title  d-flex align-items-center"><i class="bi bi-person-circle fs-3 me-2"></i>User Login</h5>
            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Email/Mobile no.</label>
                <input type="text" name="email_mobile" class="form-control shadow-none" required >
            </div>     
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control shadow-none" required>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-2">
              <button type="submit" class="btn btn-dark shadow-none">LOGIN</button>
              <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-target="#ForgotPassModal" data-bs-dismiss="modal">
              Forgot Password?
              </button> 
            </div>
          </div>
          </form>
      </div>
    </div>
  </div>
        <!-- Modal Register -->
  <div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="register-form">
          <div class="modal-header">
            <h5 class="modal-title  d-flex align-items-center"><i class="bi bi-person-lines-fill fs-3 me-2"></i>User Registration</h5>
            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: Your details must match with your ID (Identification card, Licenses, Passport, etc).
            </span>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Name</label>
                  <input name="name" type="text" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Email</label>
                  <input name="email" type="email" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Phone Number</label>
                  <input name="phone_number" type="number" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6  mb-3">
                  <label for="" class="form-label">Birth Date</label>
                  <input name="date_of_birth" type="date" class="form-control shadow-none" required>
                </div>
                <!-- <div class="col-md-6 p-0 mb-3">
                  <label for="" class="form-label">Picture</label>
                  <input name="profile_pic" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
                </div> -->
                <div class="col-md-12 mb-3">
                  <label for="" class="form-label">Address</label>
                  <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
                </div>
                <div class="col-md-12  mb-3">
                  <label for="" class="form-label">Pincode</label>
                  <input name="pincode" type="number" class="form-control shadow-none" required>
                </div>
                
                <div class="col-md-6  mb-3">
                  <label for="" class="form-label">Password</label>
                  <input name="password" type="password" class="form-control shadow-none" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="" class="form-label">Confirm Password</label>
                  <input name="password_confirm" type="password" class="form-control shadow-none" required>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-dark shadow-none">REGISTER</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
          <!-- Forgot Password Modal -->
  <div class="modal fade" id="ForgotPassModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="forgotpass-form">
          <div class="modal-header">
            <h5 class="modal-title  d-flex align-items-center "><i class="bi bi-question-circle fs-3 me-2"></i>Forgot Password</h5>
            <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
              Note: A link will be sent to your email to reset your password!
            </span>
            <div class="mb-4">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control shadow-none" required >
            </div>     
            <div class="mb-2 text-end">
              <button type="button" class="btn shadow-none p-0 me-2 " data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">CANCEL</button>
              <button type="submit" class="btn btn-dark shadow-none">SEND LINK</button>
            </div>
          </div>
          </form>
      </div>
    </div>
  </div>