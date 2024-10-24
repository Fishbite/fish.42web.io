<?php

#meta tag variable content for SEO purposes
$pageDescription = 'Drop us a line, tell us about your website, is it a new product, service, cafe, restaurant, shop? We get really excited about...';
$title = 'Contact Us';
$ogURL = 'https://fish.42web.io/contactform.php';
$ogType = 'website';
$ogPageDescription = $pageDescription;
$ogImage = 'images/about/headset-5.svg';

#in page variables
$year = date('Y');
// $joe = $usernames[0][1];

#files required to build the page
require './php/inc/header.php';
require './php/views/contactform.view.php';
require './php/inc/footer.php';

?>