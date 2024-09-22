<?php

#meta tag variable content for SEO purposes
$pageDescription = '"Contact Fishbite: drop us a line, tell us about your idea / website, we\'ll be right back to you"';
$title = 'Contact Us';
$ogURL = '"https://fish.42web.io/contactform.php"';
$ogType = '"website"';
$ogPageDescription = $pageDescription;
$ogImage = '"images/about/headset-5.svg"';

#in page variables
$year = date('Y');
// $joe = $usernames[0][1];

#files required to builf the ppage
require './php/inc/header.php';
require './php/views/contactform.view.php';
require './php/inc/footer.php';

?>