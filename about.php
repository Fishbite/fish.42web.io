<?php


#meta tag variable content for SEO purposes
$pageDescription = 'About Fishbite discloses the industry sectors in which they have extended experience.';
$title = 'About Fishbite';
$ogURL = 'https://fish.42web.io/about.php';
$ogType = 'website';
$ogPageDescription = $pageDescription;
$ogImage = 'images/dolphin-thin.svg';

#in page variables
$year = date('Y');

#files required to build the page
require './php/inc/header.php';
require './php/views/about.view.php';
require './php/inc/footer.php';
