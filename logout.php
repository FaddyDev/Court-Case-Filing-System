<?php
session_start();
unset($_SESSION['duration']);
unset($_SESSION['startTime']);
unset($_SESSION['level']);
unset($_SESSION['username']);
unset($_SESSION['category']);
unset($_SESSION['loggedin']);
header('Location:index.php');
?>