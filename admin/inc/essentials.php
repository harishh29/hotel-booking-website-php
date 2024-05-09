<?php 
    // FRONTEND PURPOSE DATA

    define('SITE_URL','http://127.0.0.1/hotel/');
    define('ABOUT_IMAGE_PATH',SITE_URL.'img/about/');
    define('CAROUSEL_IMAGE_PATH',SITE_URL.'img/carousel/');
    define('FEATURES_IMAGE_PATH',SITE_URL.'img/features/');
    define('ROOMS_IMAGE_PATH',SITE_URL.'img/room/');
    define('USER_IMAGE_PATH',SITE_URL.'img/user/');


    //SENDGRID API KEY
    define('SENDGRID_API_KEY',"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");
    define('SENDGRID_EMAIL',"kafkakaine29@gmail.com");
    define('SENDGRID_NAME',"Kafka Hotel");





    //BACKEND UPLOAD PROCESS NEED THIS DATA
    define('IMAGE_UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'].'/hotel/img/');
    define('ABOUT_FOLDER','about/'); 
    define('CAROUSEL_FOLDER', 'carousel/');
    define('FEATURES_FOLDER', 'features/');
    define('ROOM_FOLDER', 'room/');
    define('USER_FOLDER', 'user/');



    function adminLogin()
    {   
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
            echo "<script>
            window.location.href='index.php';
            </script>";
            exit;
        }
    }

    function redirect($url){
        echo "<script>
            window.location.href='$url';
        </script>";
        exit;
    }

    function alert($type, $msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">$msg</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        alert;
    }

    function uploadImage($image,$folder){
        $valid_mime = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $valid_mime)){
            return 'invalid_img';
        }
        elseif(($image['size']/ (1024*1024))>2){
            return 'invalid_size';
        }
        else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG'.random_int(11111, 99999).".$ext";
            $img_path = IMAGE_UPLOAD_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_failed';
            }
        }

    }

    function deleteImage($image, $folder){
        if(unlink(IMAGE_UPLOAD_PATH.$folder.$image)){
            return true;
        }

        else{
            return false;
        }
    }

    function uploadSVGImage($image,$folder){
        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type'];

        if(!in_array($img_mime, $valid_mime)){
            return 'invalid_img';
        }
        elseif(($image['size']/ (1024*1024))>2){
            return 'invalid_size';
        }
        else{
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $rname = 'IMG'.random_int(11111, 99999).".$ext";
            $img_path = IMAGE_UPLOAD_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else{
                return 'upd_failed';
            }
        }

    }

    // function uploadProfilePic($image){
    //     $valid_mime = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp'];
    //     $img_mime = $image['type'];

    //     if(!in_array($img_mime, $valid_mime)){
    //         return 'invalid_img';
    //     }
        
    //     else{
    //         $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    //         $rname = 'IMG'.random_int(11111, 99999).".jpeg";

    //         $img_path = USER_IMAGE_PATH.USER_FOLDER.$rname;

    //         if($ext == 'png' || $ext == 'PNG'){
    //             $img = imagecreatefrompng($image['tmp_name']);
    //         }
    //         elseif($ext == 'webp' || $ext == 'WEBP'){
    //             $img = imagecreatefromwebp($image['tmp_name']);
    //         }
    //         else{
    //             $img = imagecreatefromjpeg($image['tmp_name']);
    //         }

            
    //         if(imagejpeg($img, $img_path, 75)){
    //             return $rname;
    //         }
    //         else{
    //             return 'upd_failed';
    //         }
    //     }
    // }
?>