<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    date_default_timezone_set("Asia/Kuala_Lumpur");


    session_start();


    if(isset($_GET['fetch_rooms'])){

        // checkin/checkout  data decode
        $room_vac = json_decode($_GET['room_vac'], true);
        
        // checkin / checkout filter
        if($room_vac['checkin'] !='' && $room_vac['checkout'] != ''){
            $today_date = new DateTime(date("Y-m-d"));
            $checkin_date = new DateTime($room_vac['checkin']);
            $checkout_date= new DateTime($room_vac['checkout']);
        
            if($checkin_date == $checkout_date){
                echo "<h3 class = 'text-center text-danger'>Invalid Dates!</h3>";
                exit;
            }
            else if($checkin_date > $checkout_date){
                echo "<h3 class = 'text-center text-danger'>Check out date cannot be earlier than check in date!</h3>";
                exit;
            }
            else if($checkin_date < $today_date){
                echo "<h3 class = 'text-center text-danger'>You cannot book for past date!</h3>";
                exit;
            }
        }
        
        // guest data decode
        $guests = json_decode($_GET['guests'], true);
        $adult = ($guests['adult']!='') ? $guests['adult'] : 0;
        $children = ($guests['children']!='') ? $guests['children'] : 0;

         //facility data decode
        $facility_list =json_decode($_GET['facility_list'], true);


        //count no of rooms
        $count_rooms = 0;
        $output = "";


        //fetching settings table to verify if if website in shutdwon state
        $settings_q = "SELECT * FROM `settings` WHERE `sr_no`= 1";
        
        $settings_r = mysqli_fetch_assoc(mysqli_query($con, $settings_q));


        //query for room cards WITH GUEST FILTER
        $room_res = select("SELECT * FROM `rooms` WHERE  `adult` >=? AND `children` >= ? AND  `status` = ? AND `removed`=?",[$adult, $children, 1,0],'iiii');


          while($room_data = mysqli_fetch_assoc($room_res)){

            // check vacancy filter

            if($room_vac['checkin']!= '' && $room_vac['checkout'] != ''){
                $tb_query ="SELECT COUNT(*) AS `total_booking` FROM `booking_order` WHERE `booking_status` =? AND `room_id` = ? 
                    AND `check_out` > ? AND `check_in` < ?";
        
                $values = ['booked', $room_data['id'],$room_vac['checkin'], $room_vac['checkout']];

                $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values,'siss')) ;
                
               

                if(($room_data['quantity']-$tb_fetch['total_booking'])==0){
                    continue;
                }
            }



            //get features of room

            $fea_q = mysqli_query($con, "SELECT f.name FROM `features` f
                      INNER JOIN `room_features` rf ON f.id = rf.features_id
                      WHERE rf.room_id = '$room_data[id]'" );

            $features_data ='';

            while($fea_row = mysqli_fetch_assoc($fea_q)){
              $features_data .= "<span class='badge rounded-pill bg-light text-dark  text-wrap'>
                                $fea_row[name]
                                </span>";
            }




            //get facilities of room

            $fac_count = 0;


            $fac_q = mysqli_query($con, "SELECT fac.name, fac.id FROM `facilities` fac
                      INNER JOIN `room_facilities` rfac ON fac.id = rfac.facilities_id
                      WHERE rfac.room_id = '$room_data[id]'" );
            
            $facilities_data ='';

            while($fac_row = mysqli_fetch_assoc($fac_q)){
                if(in_array($fac_row['id'],$facility_list['facilities'])){
                    $fac_count++;
                }
                $facilities_data .= "<span class='badge rounded-pill bg-light text-dark  text-wrap'>
                                    $fac_row[name]
                                    </span>";
            }

            if(count($facility_list['facilities'])!= $fac_count){
                continue;
            }

            //get thumbnail of image

            $room_thumbnail = ROOMS_IMAGE_PATH."thumbnail.jpg";

            $thumb_q = mysqli_query($con,"SELECT * FROM `room_image` WHERE `room_id`='$room_data[id]' AND `thumb`='1'");

            if(mysqli_num_rows($thumb_q)>0){
              $thumb_res = mysqli_fetch_assoc($thumb_q);
              $room_thumbnail = ROOMS_IMAGE_PATH.$thumb_res['image'];
            }

            //if website not shutdown, enable book button
            $book_btn = "";

            if(!$settings_r['shutdown']){
              $login = 0;
              if(isset($_SESSION['login']) && $_SESSION['login'] == true){
                $login = 1;
              }
              $book_btn ="<button onclick= 'checkLoginToBook($login, $room_data[id])'  class='btn btn-sm text-white custom-bg shadow-none w-100 mb-2'>BOOK NOW</button>";
            }

              //star for rating
              $rating_q = "SELECT ROUND(AVG(rating)) AS `avg_rating` FROM `rating_review` WHERE `room_id` = '$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20 ";

              $rating_r = mysqli_query($con,$rating_q);
  
              $rating_fetch = mysqli_fetch_assoc($rating_r);
              
              $rating_data = "";
  
              if($rating_fetch['avg_rating']!= NULL){
                $rating_data = "<div class='rating mb-4'>
                                  <h6 class='mb-1'>Rating</h6>
                                  <span class='badge rounded-pill bg-light'>";
                for($i=0; $i<$rating_fetch['avg_rating']; $i++){
                  $rating_data .= "<i class='bi bi-star-fill text-warning ps-1'></i>";
                }

                for($i=0; $i < 5-$rating_fetch['avg_rating']; $i++){
                  $rating_data .= "<i class='bi bi-star-fill text-secondary ps-1'></i>";
                }
                $rating_data .= " </span>
                                </div>";
              }


            //print room card
            $output .="
                <div class='card mb-4 border-0 shadow pop' >
                    <div class='row g-0 p-3 align-items-center'>
                      <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                        <img src='$room_thumbnail' class='img-fluid rounded' alt='...'>
                      </div>
                      <div class='col-md-5 px-lg-3 px-md-3 px-0'>
                        <h5 class='mb-3'>$room_data[room_name]</h5>
                        <div class='features mb-3'>
                          <h6 class='mb-1'>Features</h6>
                            $features_data
                        </div>
                        <div class='facilities mb-3'>
                          <h6 class='mb-1'>Facilities</h6>
                            $facilities_data
                        </div>
                        <div class='guest mb-3'>
                          <h6 class='mb-1'>Guests</h6>
                            <span class='badge rounded-pill bg-light text-dark  text-wrap'>
                              $room_data[adult] Adult
                            </span>
                            <span class='badge rounded-pill bg-light text-dark  text-wrap'>
                              $room_data[children] Children
                            </span>
                        </div>
                         $rating_data   
                      </div>
                      <div class='col-md-2 mt-lg-0 mt-md-0 mt-4 text-align-center'>
                        <h6 class='mb-4'>RM $room_data[price] per night</h6>
                        $book_btn
                        <a href='room_details.php?id=$room_data[id]' class='btn btn-sm btn-outline-dark shadow-none w-100 mb-2'>More Details</a>
                      </div>
                    </div>
                </div>";
            $count_rooms++;

        }

        if($count_rooms>0){
            echo $output;

        }
        else{
            echo "<h3 class'text-center'>No rooms to show!</h3>";
        }
    }

?>