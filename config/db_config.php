<?php

    $GLOBALS['db'] = $db = new mysqli("localhost", "root", "", "epc");

    if($db->connect_error){
        header('Location: ../error.php');
    }

?>