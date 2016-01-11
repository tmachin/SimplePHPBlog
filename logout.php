<?php
/*
* logout.php
* clears session
* also clears admin status
* @author Thomas Machin

*/
    session_start();
    unset($_SESSION["loggedin"]);
    unset($_SESSION["email"]);
    unset($_SESSION['admin']);
    $_SESSION = array(); // reset array for this session
    session_destroy(); // destroy the session
    header("Location: index.php");
    exit();
?>
