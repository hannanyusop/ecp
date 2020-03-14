<?php

    $GLOBALS['db'] = $db = new mysqli("localhost", "root", "", "ecp");

    if($db->connect_error){
        header('Location: ../error.php');
    }

?>