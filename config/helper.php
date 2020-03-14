<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

include_once 'db_config.php';

function displayPrice($price){

    return "RM ".number_format($price, 2, '.', '');
}

function getUser(){

    $result = $GLOBALS['db']->query("SELECT * FROM users WHERE id=$_SESSION[user_id]");
    return $result->fetch_assoc();

}

function getYear(){
    $start = 2005;
    $years = [];
    do{
        $years[] = $start; $start++;
    }while($start <= date('Y'));

    return $years;
}

function getStrMonth($int = null){

    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    ];

    if(is_null($int)){
        return $months;
    }

    return $months[$int];

}

function getJobStatus($status = null){

    $statuses = [
        1 => 'Pending',
        2 => 'Accepted',
        3 => 'Completed',
        4 => 'Rejected',
        5 => 'Picked'
    ];

    if(is_null($status)){
        return $statuses;
    }else{
        return $statuses[$status];
    }

}

function getTransactionType($type){

    $types = [
        1 => 'Top-up',
        2 => 'Payment',
        3 => 'Refund'
    ];

    return $types[$type];
}

#for testing
function dd($data){
    var_dump($data);exit();
}

function getFileExt($file){

    return (file_exists($file)) ? strtoupper(pathinfo($file, PATHINFO_EXTENSION)) : "File Not Found!";
}

function getFileSize($file){
    return (file_exists($file)) ? filesize($file)." KB" : "File Not Found!";
}

function getRole($role_id = null){

    $roles = [
        1 => 'MANAGER',
        2 => 'STAFF',
        3 => 'CUSTOMER'
    ];

    if(is_null($role_id)){
        return $roles;
    }

    return $roles[$role_id];
}

function getBackendRole($role_id = null){

    $roles = [
        1 => 'MANAGER',
        2 => 'STAFF',
    ];

    if(is_null($role_id)){
        return $roles;
    }

    return $roles[$role_id];
}


function getAddOnStatus($status = null){


    $statuses = [
        1 => 'ACTIVE',
        0 => 'DISABLED',
    ];

    return (is_null($status))? $statuses : $statuses[$status];

}

function getOption($name, $default = ''){

    $option_q = $GLOBALS['db']->query("SELECT * FROM options WHERE name='$name'");
    $option = $option_q->fetch_assoc();

    if(!$option){
        return $default;
    }

    return $option['value'];

}

function sendEmail($recipient_email, $subject, $body){


    #check $GLOBALS['send_email']

    if(!$GLOBALS['send_email']){
        return true;
    }


    if($GLOBALS['xampp_macos']){

        include '../vendor/autoload.php';

    }else{
        require $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = $GLOBALS['smtp_host'];                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $GLOBALS['smtp_username'];                     // SMTP username
        $mail->Password   = $GLOBALS['smtp_password'];                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 25;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('ecenterprinting@yahoo.com', 'nor-reply ECP');
        $mail->addAddress($recipient_email);     // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
//        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generateResetPasswordKey() {
    $alphabet = 'abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 12; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generateConfirmationCode() {
    $alphabet = '1234567890987654321234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function getPrintingMode($mode = null){

    $modes = [
        1 => 'Colour',
        2 => 'Black & White'
    ];

    return (is_null($mode))? $modes : $modes[$mode];
}
function getCheckedAddOn($addOnId){

    return (isset($_SESSION['jobs'][$_SESSION['auth']['user_id']]['addOn'][$addOnId]))? 'CHECKED' : '';
}

function insertJobTransaction($job_id, $staff_id, $status, $note){


    $sql = "INSERT INTO job_transaction (job_id,staff_id,status,note) VALUES ($job_id, $staff_id, $status, '$note')";


    if (!$GLOBALS['db']->query($sql)) {
        echo "Error: " . $sql . "<br>" . $GLOBALS['db']->error; exit();
    }

    return true;

}

function getTrackListAccepted(){

    $statuses = [
        1 => 'You created a job.',
        2 => 'Your job has been received.',
        3 => 'Document is ready.',
        5 => 'Document has been picked.'
    ];

    return $statuses;

}

function insertNotification($user_id, $title, $message){

    $sql = "INSERT INTO notifications (user_id,seen,title,messages) VALUES ($user_id, 0, '$title', '$message')";

    if (!$GLOBALS['db']->query($sql)) {
        echo "Error: " . $sql . "<br>" . $GLOBALS['db']->error; exit();
    }
    return true;
}

function getTimeAgo($timestamp){

date_default_timezone_set("Asia/Kolkata");
  $time_ago        = strtotime($timestamp);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;

  $minutes = round($seconds / 60); // value 60 is seconds
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
  $weeks   = round($seconds / 604800); // 7*24*60*60;
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60

  if ($seconds <= 60){

      return "Just Now";

  } else if ($minutes <= 60){

      if ($minutes == 1){

          return "one minute ago";

      } else {

          return "$minutes minutes ago";

      }

  } else if ($hours <= 24){

      if ($hours == 1){

          return "an hour ago";

      } else {

          return "$hours hrs ago";

      }

  } else if ($days <= 7){

      if ($days == 1){

          return "yesterday";

      } else {

          return "$days days ago";

      }

  } else if ($weeks <= 4.3){

      if ($weeks == 1){

          return "a week ago";

      } else {

          return "$weeks weeks ago";

      }

  } else if ($months <= 12){

      if ($months == 1){

          return "a month ago";

      } else {

          return "$months months ago";

      }

  } else {

      if ($years == 1){

          return "one year ago";

      } else {

          return "$years years ago";

      }
  }
}

function strLimit($string, $limit = 20){
    return (strlen($string) > $limit)?substr($string, 0, $limit) . '...' : $string ;
}


