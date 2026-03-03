<?php
    session_start();
    if(isset($_SESSION['id'])) {
        header("Location: pages/home.php");
    }
    else {
        header("Location: auth/login.php");
    }
?>