<?php


session_start();
require_once('vendor/autoload.php');


#call al class
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$barCodePNG = new Picqer\Barcode\BarcodeGeneratorPNG();


#for error reporting
//error_reporting(0);

#database
include_once 'config/db_config.php';

#include helper.php
include_once "config/helper.php";

$GLOBALS['APP_NAME'] = 'E-CENTER PRINTING';

#PHP Mailer
//ecenterprinting
$GLOBALS['smtp_username'] = 'ecenterprinting@yahoo.com';
$GLOBALS['smtp_password'] = 'idwfwfybfmqgkgfc';
$GLOBALS['smtp_host'] = 'smtp.mail.yahoo.com';
$GLOBALS['admin_email'] = 'nan_s96@yahoo.com';

$GLOBALS['xampp_macos'] = true;
$GLOBALS['send_email'] = true;

?>