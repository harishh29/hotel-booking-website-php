<?php 

    require('inc/essentials.php');

    session_start();
    unset($_SESSION['adminLogin']);
    
    redirect('index.php');

?>