<?php 

    require('admin/inc/essentials.php');

    session_start();
    unset($_SESSION['login']);
    // session_destroy();
    redirect('index.php');

?>