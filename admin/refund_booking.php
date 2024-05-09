<?php 
    require('inc/essentials.php');  
    require('inc/db_config.php') ;

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Refund Booking</title>
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
                <h3 class="mb-4">Refund Booking</h3>

                <!-- User Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <input type="text" oninput="get_booking(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Type to search booking">
                            
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1300px;">
                                <thead class="first-bg text-light">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User Details</th>
                                    <th scope="col">Room Details</th>
                                    <th scope="col">Refund Amount</th>
                                    <th scope="col">Action</th>
                                   

                                    </tr>
                                </thead>
                                <tbody id ="table-data">
                                    
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    



    <?php 
        require('inc/script.php');
    ?>

    <script src="scripts/refund_booking.js"></script>

    
</body>
</html>