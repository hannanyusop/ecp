<?php
	require_once '../../env.php';

    if(isset($_SESSION['auth'])){

        if($_SESSION['auth']['role'] != 3){
            session_destroy(); #delete all session
            echo "<script>alert('Access denied!');window.location='../login.php';</script>";
        }

    }else{
        echo "<script>alert('Session ended! Please re-login!');window.location='../login.php';</script>";
    }

    $user_id = $_SESSION['auth']['user_id'];

    $result = $db->query("SELECT *,accounts.id as account_id FROM users  LEFT JOIN  accounts ON users.id = accounts.user_id WHERE users.id=$user_id");
    $user = $result->fetch_assoc();

?>