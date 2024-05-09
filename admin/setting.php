<?php 
    require('inc/essentials.php');   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Setting</title>
    <?php 
        require('inc/links.php');
    ?>
</head>
<body class="bg-light">
<?php 
        require('inc/header.php');
    ?>
    

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Settings</h3>

                <!-- General Setting -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#g-setting">
                            <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                        <p class="card-text" id="site_about"></p>
                    </div>
                </div>

                <!-- General setting modal -->
                <div class="modal fade" id="g-setting" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="g_setting_form">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">General Settings</h5>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label fw-bold">Site Title</label>
                                    <input name="site_title" type="text" id="site_title_input" class="form-control shadow-none" required>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label fw-bold">About Us</label>
                                    <textarea name="site_about" id="site_about_input" class="form-control shadow-none" rows="6" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="site_title.value =  general_data.site_title, site_about.value =  general_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Shutdown Setting -->
                <div class="card border-0 shadow-sm mb-4" >
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown website</h5>
                            <div class="form-check form-switch">
                                <form >
                                <input onchange="upd_shutdown(this.value)" class="form-check-input shadow-none" type="checkbox" id="shutdown_toggle">
                                </form>
                            </div>
                            
                        </div>
                        
                        <p class="card-text">When website is offline, customer unable to book rooms</p>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Contact Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#c-setting">
                            <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Address</h6>
                                    <p class="card-text" id="address"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Google maps</h6>
                                    <p class="card-text" id="gmap"></p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Phone No</h6>
                                    <p class="card-text mb-1" >
                                        <i class="bi bi-telephone-fill"></i>
                                        +<span id="phn1"></span>
                                    </p>
                                    
                                    <p class="card-text" >
                                        <i class="bi bi-telephone-fill"></i>
                                        +<span id="phn2"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Email</h6>
                                    <p class="card-text" id="email"></p>
                                </div>    
                            </div>
                            <div class="col-lg-6">
                            <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">Social Links</h6>
                                    <p class="card-text mb-1" >
                                        <i class="bi bi-twitter-x"></i>
                                        <span id="tw"></span>
                                    </p>
                                    <p class="card-text mb-1" >
                                        <i class="bi bi-instagram"></i>
                                        <span id="ig"></span>
                                    </p>
                                    <p class="card-text" >
                                        <i class="bi bi-facebook"></i>
                                        <span id="fb"></span>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="card-subtitle mb-1 fw-bold">iframe</h6>
                                    <iframe id="iframe" class="border w-100 p-2" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>

                <!-- Contact setting modal-->
                <div class="modal fade" id="c-setting" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form id="c_setting_form">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Contact Settings</h5>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid p-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label fw-bold">Address</label>
                                                <input name="address" type="text" id="address_input" class="form-control shadow-none" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label fw-bold">Google Map Link</label>
                                                <input name="gmap" type="text" id="gmap_input" class="form-control shadow-none" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label fw-bold">Phone Numbers (with country code)</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                    <input type="number" name="phn1" id="phn1_input" class="form-control shadow-none" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                                    <input type="number" name="phn2" id="phn2_input" class="form-control shadow-none" >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label fw-bold">Email</label>
                                                <input name="email" type="email" id="email_input" class="form-control shadow-none" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label fw-bold">Social Link</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                                                    <input type="text" name="tw" id="tw_input" class="form-control shadow-none" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                                    <input type="text" name="ig" id="ig_input" class="form-control shadow-none" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                                    <input type="text" name="fb" id="fb_input" class="form-control shadow-none" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="" class="form-label fw-bold">iFrame Source</label>
                                                <input name="iframe" type="text" id="iframe_input" class="form-control shadow-none" required>
                                            </div>
                                            
                                        </div>

                                    </div>
                                </div>



                                
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="contact_input(contact_data)" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Management Setting -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Management Setting</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#m-setting">
                            <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>
                        <div class="row" id="team_data">
                        </div> 
                    </div>
                </div>

                <!-- Management setting modal -->
                <div class="modal fade" id="m-setting" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="m_setting_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Team Member</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-bold">Name</label>
                                        <input name="member_name" type="text" id="member_name_input" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-bold">Picture</label>
                                        <input name="member_pic" type="file" id="member_pic_input" class="form-control shadow-none" accept="[.jpg, .jpeg, .png, .webp]" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="member_name.value='', member_pic.value='' " class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?PHP echo $_SERVER['DOCUMENT_ROOT'] ?>

            </div>
        </div>
    </div>



    <?php 
        require('inc/script.php');
    ?>
    
    <script src="scripts/settings.js"></script>
</body>
</html>