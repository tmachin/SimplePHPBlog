<?php
require('configure.php');
try {
    $db = new PDO('mysql:host='.$DBhost.';dbname='.$DBname, $DBusername, $DBpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //var_dump($db);
    //
    //exit();
} catch (Exception $e) {
    echo $e->getMessage();
    //echo "Sorry PDO connection problem";
    exit();
}


?>
