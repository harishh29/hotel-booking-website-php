<?php 
    require('../admin/inc/db_config.php');
    require('../admin/inc/essentials.php');
    require("../inc/sendgrid/sendgrid-php.php");
    date_default_timezone_set("Asia/Kuala_Lumpur");



    function send_email($uemail, $token, $type){
        if($type ==  "email_confirmation"){
            $page = 'email_confirm.php';
            $subject = "Account Verification Link";
            $content = "verify your account";
        }
        else{
            
            $page = 'index.php';
            $subject = "Account Recovery Link";
            $content = "reset your password";
        }

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom(SENDGRID_EMAIL, SENDGRID_NAME);
        $email->setSubject($subject);

        $email->addTo($uemail );

        $email->addContent(
            "text/html", "Click the link to $content: <br>
            <a href='".SITE_URL."$page?$type&email=$uemail&token=$token"."'>Click Here</a>"
        );

        $sendgrid = new \SendGrid(SENDGRID_API_KEY);
        try{
            $sendgrid->send($email);
            return 1;
        }
        
        catch(Exception $e){
            return 0;
        }
         
        

    }

    if(isset($_POST['register'])){
        $data = filteration($_POST);

        // to confirm both password matched

        if($data['password'] != $data['password_confirm']){
            echo 'pass_mismatch';
            exit;
        }

        // check if user exist

        $user_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? AND `phone_number` = ? LIMIT 1", [$data['email'], $data['phone_number']],'ss');
        
        if(mysqli_num_rows($user_exist)!= 0){
            $user_exist_fetch = mysqli_fetch_assoc($user_exist);
            echo ($user_exist_fetch['email']== $data['email']) ? 'email_already' : 'phone_already';
            exit;
        }

        //upload user profil picture to server

        // $img = uploadProfilePic($_FILES['profile_pic']);

        // if($img == 'invalid_img'){
        //     echo 'invalid_img';
        //     exit;
        // }
        // else if($img == 'upd_failed'){
        //     echo 'upd_failed';
        //     exit;
        // }

        // send confirmation link to users email
        $token = bin2hex(random_bytes(16));

        if(!send_email($data['email'], $token, "email_confirmation")){
            echo 'mail_failed';
            exit;
        }

        $enc_pass = password_hash($data['password'], PASSWORD_BCRYPT);

        // $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phone_number`, `pincode`, `date_of_birth`, `profile_pic`, `password`, `token`) 
        //           VALUES (?,?,?,?,?,?,?,?,?) ";

        // $values = [$data['name'], $data['email'], $data['address'], $data['phone_number'], $data['pincode'], $data['date_of_birth'], $img, $enc_pass, $token];

        $query = "INSERT INTO `user_cred`(`name`, `email`, `address`, `phone_number`, `pincode`, `date_of_birth`, `password`, `token`) 
                  VALUES (?,?,?,?,?,?,?,?) ";

        $values = [$data['name'], $data['email'], $data['address'], $data['phone_number'], $data['pincode'], $data['date_of_birth'],  $enc_pass, $token];

        if(insert($query, $values,'ssssssss')){
            echo 1;
        }
        else{
            echo 'insert_failed';
        }
    }

    if(isset($_POST['login'])){
        $data = filteration($_POST);

        //check if user exist
        $user_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? OR `phone_number` = ? LIMIT 1", [$data['email_mobile'], $data['email_mobile']],'ss');
        
        if(mysqli_num_rows($user_exist)== 0){
            echo 'inv_email_mobile';
        }
        else{
            $user_fetch = mysqli_fetch_assoc($user_exist);

            if($user_fetch['verified']==0){
                echo 'not_verified';
            }
            else if($user_fetch['status']==0){  
                echo 'inactive';
            }
            else{
                if(!password_verify($data['password'], $user_fetch['password'])){
                   echo 'invalid_password'; 
                }
                else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uID'] = $user_fetch['id'];
                    $_SESSION['uName'] = $user_fetch['name'];
                    // $_SESSION['uProfilePic'] = $user_fetch['profle_pic'];
                    $_SESSION['uPhone'] = $user_fetch['phone_number'];
                    echo 1;
                }
            }
        }
        
    }

    if(isset($_POST['forgot_pass'])){
        $data = filteration($_POST);

        $user_exist = select("SELECT * FROM `user_cred` WHERE `email` = ? LIMIT 1", [$data['email']],'s');

        if(mysqli_num_rows($user_exist)== 0){
            echo 'invalid_email';
        }
        else{
            $user_fetch = mysqli_fetch_assoc($user_exist);

            if($user_fetch['verified']==0){
                echo 'not_verified';
            }
            else if($user_fetch['status']==0){  
                echo 'inactive';
            }
            else{
                // send link to email
                $token = bin2hex(random_bytes(16));
                if(!send_email($data['email'], $token, 'reset_password')){
                    echo 'mail_failed';
                }
                else{
                    $date = date("Y-m-d");
                    $query = mysqli_query($con, "UPDATE `user_cred` SET `token`='$token' ,`t_expire`='$date' WHERE `id` ='$user_fetch[id]' ");

                    if($query){
                        echo 1;
                    }
                    else{
                        echo 'upd_failed';
                    }

                }
            }
        }


    }

    if(isset($_POST['reset_pass'])){
        $data = filteration($_POST);

        $enc_pass = password_hash($data['password'], PASSWORD_BCRYPT);

        $query ="UPDATE `user_cred` SET `password`=?, `token`=? ,`t_expire`=? WHERE `email` =? AND `token`=? ";

        $values = [$enc_pass, null, null, $data['email'], $data['token']];

        if(update($query, $values, 'sssss')){
            echo 1;
        }
        else{
            echo 'failed';
        }




    }
?>