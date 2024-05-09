<?php 
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();
    
 

    if(isset($_POST['get_booking'])){
        $frm_data = filteration($_POST);



        $query = "SELECT bo.*, bd.*  FROM `booking_order` bo INNER JOIN `booking_detail` bd
                    ON bo.booking_id = bd.booking_id 
                    WHERE (bo.order_id LIKE ? OR bd.phone_number LIKE ? OR bd.user_name LIKE ?) 
                    AND (bo.booking_status = ? AND bo.refund = ?) 
                    ORDER BY bo.booking_id ASC";

        $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%","%$frm_data[search]%", "cancelled", 0], 'sssss');
        $i=1; 
        $table_data = "";
        
        if(mysqli_num_rows($res)==0){
            echo "<b>No Data Found</b>";
            exit;
        }
        while($data = mysqli_fetch_assoc($res)){

            $date = date("d-m-Y", strtotime($data['date_time']));
            $checkin = date("d-m-Y", strtotime($data['check_in']));
            $checkout = date("d-m-Y", strtotime($data['check_out']));

            $table_data .="
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-primary'>Order ID: $data[order_id]</span>
                    <br>
                    <b>Name: </b>$data[user_name]
                    <br>
                    <b>Phone no: </b>$data[phone_number]
                </td>
                
                <td>
                    <b>Paid: </b> $data[room_name]
                    <br>
                    <b>Check-in: </b>$checkin 
                    <br>
                    <b>Check-out: </b>$checkout
                    <br>
                    <b>Date: </b>$date
                </td>
                <td>
                    <b>RM $data[trans_amt]</b> 
                </td>
                <td>
                    <button type='button' onclick='refund_booking($data[booking_id])' class=' mt-3 btn btn-sm btn-success shadow-none' data-bs-toggle='modal' >
                    <i class='bi bi-cash-stack'></i> Refund
                    </button>
                </td>
            
            </tr>
            ";
            $i++;
        }
        echo $table_data;
    }   

    

    
    

    
    
   
    if(isset($_POST['refund_booking'])){
        $frm_data = filteration($_POST);
        
        $query = "UPDATE `booking_order` SET  `refund` =? WHERE `booking_id`=?";
        $values = [ 1, $frm_data['booking_id']];
        $res = update($query, $values, 'ii');

        echo $res;

    }

    
    
        
?>