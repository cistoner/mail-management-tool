<?php
/**
 * code to perform the logout functionality
 */
 session_start();
 $checkVar = true;
 include '../config/config.php';
 unset($_SESSION[username_key]);
 unset($_SESSION[password_key]);
 unset($_SESSION['id']);
 session_destroy();
 header("location: ../login.php?message=Logged+out+sucessfully&success=false");
 exit;
?>