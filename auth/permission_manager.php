<?php
    require_once '../../env.php';

    if(isset($_SESSION['auth'])){

        #manager only
        if($_SESSION['auth']['role'] != 1){
            session_destroy(); #delete all session
            echo "<script>alert('Access denied!');window.location='login.php';</script>";
        }

    }else{
        echo "<script>alert('Session ended! Please re-login!');window.location='login.php';</script>";
    }

    $user_id = $_SESSION['auth']['user_id'];

    $result = $db->query("SELECT * FROM users WHERE id=$user_id");
    $user = $result->fetch_assoc();

    $noty_1 = $db->query("SELECT * FROM notifications WHERE seen=0 AND user_id=$user_id");
    $noty_2 = $db->query("SELECT * FROM notifications WHERE seen=0 AND user_id=$user_id");

?>