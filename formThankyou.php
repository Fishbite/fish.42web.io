<?php 
session_start();

#meta tag variable content for SEO purposes
$pageDescription = 'Fisbite\'s thank you page that only appears after a form submission. The contact form has been completed';
$title = 'Thankyou!';
$ogURL = 'https://fish.42web.io/formThankyou.php';
$ogType = 'website';
$ogPageDescription = $pageDescription;
$ogImage = 'images/dolphin-thin.svg';

#in page variables
$year = date("Y");
$data = $_SESSION;

require "./php/lib/utils.php";
include "./php/inc/header.php";
include "./php/views/formThankyou.view.php";
include "./php/inc/footer.php";
?>