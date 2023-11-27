<?php
session_start();
if(!isset($_SESSION['uName']))
{
    header("Location: login.php");
}


?>