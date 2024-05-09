<?php 
    require('inc/essentials.php');  
    require('inc/db_config.php') ;

    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);

        if($frm_data['seen']=='all'){
            $q = "UPDATE `rating_review` SET `seen`=?";
            $values = [1];
            if(update($q,$values,'i')){
                alert('success', 'Marked as read');
            }
            else{
                alert('danger', 'Operation Failed');
            }
        }
        else{
            $q = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if(update($q,$values,'ii')){
                alert('success', 'All Marked as Read');
            }
            else{
                alert('danger', 'Operation Failed');
            }
        }
    }
    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);
        if($frm_data['del']=='all'){
            $q = "DELETE FROM  `rating_review`";
            
            if(mysqli_query($con,$q)){
                alert('success', 'All Message Deleted');
            }
            else{
                alert('danger', 'Operation Failed');
            }

        }
        else{
            $q = "DELETE FROM  `rating_review` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(delete($q,$values,'i')){
                alert('success', 'Message Deleted');
            }
            else{
                alert('danger', 'Operation Failed');
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rating & Reviews</title>
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
                <h3 class="mb-4">RATING & REVIEWS</h3>

                

                <!-- Queries Section -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-sm rounded-pill shadow-none btn-dark"><i class="bi bi-check2-all"></i> Mark all as read</a>
                            <a href="?del=all" class="btn btn-sm rounded-pill shadow-none btn-danger"><i class="bi bi-trash"></i> Delete all</a>
                        </div>

                        <div class="table-responsive-md">
                        <table class="table table-hover border ">
                            <thead class=" first-bg text-light">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Room Name</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Rating</th>
                                <th scope="col" width="30%">Review</th>
                                <th scope="col">Date</th>
                                <th scope="col" width="10%">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $q = "SELECT rr.*, uc.name AS uname, r.room_name AS rname FROM `rating_review` rr 
                                    INNER JOIN `user_cred` uc ON rr.user_id = uc.id
                                    INNER JOIN `rooms` r ON rr.room_id = r.id
                                    ORDER BY `sr_no` DESC";
                                    $data = mysqli_query($con, $q);
                                    $i = 1;

                                    while($row = mysqli_fetch_assoc($data)){
                                        $date = date('d-m-Y', strtotime($row['date_time']));
                                        $seen = '';
                                        if($row['seen']!=1){
                                            $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary mb-2'>Mark as read</a> <br>";
                                        }
                                        $seen.="<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger'>Delete</a>";

                                        echo<<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>$row[rname]</td>
                                                <td>$row[uname]</td>
                                                <td>$row[rating]</td>
                                                <td>$row[review]</td>
                                                <td>$date</td>
                                                <td>$seen</td>
                                            </tr>
                                        query;
                                        $i++;
                                    }
                                
                                ?>
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
    
    
</body>
</html>