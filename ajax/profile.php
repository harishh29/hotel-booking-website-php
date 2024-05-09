<?php
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    date_default_timezone_set("Asia/Kuala_Lumpur");

    if(isset($_POST['profile_form'])){
        $frm_data = filteration($_POST);

        session_start();
        $user_exist = select("SELECT * FROM `user_cred` WHERE  `phone_number` = ? AND `id` !=? LIMIT 1", [$frm_data['phone_number'],$_SESSION['uID']],'ss');

        if(mysqli_num_rows($user_exist)!= 0){
            echo 'phone_already';
            exit;
        }

        $query = "UPDATE `user_cred` SET `name` =?, `phone_number` =?, `date_of_birth` =?, `address` =?, `pincode` =? WHERE `id` =? ";

        $values = [$frm_data['name'], $frm_data['phone_number'], $frm_data['date_of_birth'], $frm_data['address'], $frm_data['pincode'], $_SESSION['uID']];

       

        if(update($query, $values, 'ssssss')){
            $_SESSION['uName'] = $frm_data['name'];
            echo 1;
        }
        else{
            echo 0;
        }
    }

    if(isset($_POST['pass_form'])){
        $frm_data = filteration($_POST);
        session_start();

        if($frm_data['password']!= $frm_data['password_confirm']){
            echo 'mismatch';
            exit;
        }

        $enc_pass = password_hash($frm_data['password'],PASSWORD_BCRYPT);

        $query = "UPDATE `user_cred` SET `password` =?  WHERE `id`= ? LIMIT 1";
        $values = [$enc_pass, $_SESSION['uID']];

        if(update($query, $values, 'ss')){
            
            echo 1;
        }
        else{
            echo 0;
        }

    }
?>