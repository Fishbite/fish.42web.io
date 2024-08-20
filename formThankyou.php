<?php 
session_start();

$title = "Thankyou!";
$year = date("Y");
$data = $_SESSION;

require "./php/lib/utils.php";
include "./php/inc/header.php";
include "./php/views/formThankyou.view.php";
include "./php/inc/footer.php";
?>