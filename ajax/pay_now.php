<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essentials.php');
date_default_timezone_set("Asia/Kuala_Lumpur");

session_start();


$order_id = 'ORD_'.$_SESSION['uID'].random_int(11111,99999);
$cust_id = $_SESSION['uID'];
$trans_id = 'TR_'.$_SESSION['uID'].random_int(11111,99999);
$trans_amt = $_SESSION['room']['payment'];






if(isset($_POST['booking_order'])){
   
   
    $frm_data = filteration($_POST);


    // booking order 
    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `trans_id`, `trans_amt`) 
    VALUES (?,?,?,?,?,?,?) ";

    insert($query1, [$cust_id, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $order_id, $trans_id, $trans_amt], 'issssss');


    // booking detail
    $booking_id = mysqli_insert_id($con);

    $query2 = "INSERT INTO `booking_detail`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phone_number`, `address`)
    VALUES (?,?,?,?,?,?,?) ";

    insert($query2, [$booking_id, $_SESSION['room']['room_name'], $_SESSION['room']['price'], $trans_amt, $frm_data['name'], $frm_data['phone_number'], $frm_data['address']], 'issssss');


    //test 
    $select_q = "SELECT  `booking_id`, `user_id` FROM `booking_order` WHERE `order_id` = $order_id";
    $select_res = mysqli_query($con, $select_q);

    if(mysqli_num_rows($select_res)==0){
        redirect('index.php');
    }

    $select_fetch = mysqli_fetch_assoc($select_res);


}


?>