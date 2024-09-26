<?php
#meta tag variable content for SEO purposes
$pageDescription = 'Fishbite is home, Hire me, for all your web development needs. Concept, Functionality, Design, Programming, SEO, Hosting, Domain Registration';
$title = 'Fishbite is Home';
$ogURL = 'https://fish.42web.io';
$ogType = 'website';
$ogPageDescription = $pageDescription;
$ogImage = 'images/dolphin-thin.svg';

#In page variables
$year = date('Y');
$joe = "Girl on the web";
$designer = "Designer @ work";

#files required to build the page
require './php/inc/header.php';
require './php/views/index.view.php';
require './php/inc/footer.php';

?>