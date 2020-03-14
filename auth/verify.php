<?php

require_once '../env.php';

if(isset($_POST['email']) && isset($_POST['password'])){

    $email = $_POST['email']; $password = $_POST['password'];

    $result = $db->query("SELECT * FROM users WHERE email='$email'");
    $user = $result->fetch_assoc();

    $ip = $_SERVER['REMOTE_ADDR'];

    if($user){

        #check password hashing
        if (password_verify($password, $user['password'])) {

            $q = $db->query("UPDATE users SET last_ip_address='$ip', last_login_at=now() WHERE id=$user[id]");
            $x = $db->query($q);

            $_SESSION['auth'] = [
                'user_id' => (int)$user['id'],
                'role' => (int)$user['role_id'],
                'fullname' => $user['fullname'],
            ];

            if($user['role_id'] == 3){
                #customer

                header('Location:customer/dashboard.php');

            }elseif($user['role_id'] == 2 || $user['role_id'] == 1){
                #staff & manager
                header('Location:staff/dashboard.php');
            }

        }else{
            echo "<script>alert('Invalid Password!');window.location='login.php'</script>";
        }

    }

    echo "<script>alert('Invalid Email!');window.location='login.php'</script>";


}else{
    header('Location:login.php');
}
?>