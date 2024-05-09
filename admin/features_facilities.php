<?php 
    require('inc/essentials.php');  
    require('inc/db_config.php') ;

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Features & Facilities</title>
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
                <h3 class="mb-4">FEATURES & FACILITIES</h3>

                <!-- Features Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">FEATURES</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#ft-setting">
                            <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border ">
                                <thead class="first-bg text-light">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody id ="feature-data">
                                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

                <!-- Facilites Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">FACILITIES</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#fc-setting">
                            <i class="bi bi-plus-square"></i> Add
                            </button>
                        </div>

                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                            <table class="table table-hover border ">
                                <thead class="first-bg text-light sticky-top">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" width="40%">Description</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id ="facility-data">
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Features setting modal -->
    <div class="modal fade" id="ft-setting" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="ft_setting_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Features</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Name</label>
                            <input name="feature_name" type="text" class="form-control shadow-none" required>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="reset"  class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Facility setting modal -->
    <div class="modal fade" id="fc-setting" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="fc_setting_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Facility</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Name</label>
                            <input name="facility_name" type="text" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Icon</label>
                            <input name="facility_icon" type="file" class="form-control shadow-none" accept=".svg" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Description</label>
                            <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php 
        require('inc/script.php');
    ?>

    <script src="scripts/features_facilities.js"></script>

    
</body>
</html>