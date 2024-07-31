<?php
require 'php/user.php';

$title = 'Fishbite is Home';
$year = date('Y');
$joe = $usernames[0][1];
require 'header.php';
require 'index.view.php';
require 'footer.php';

?>