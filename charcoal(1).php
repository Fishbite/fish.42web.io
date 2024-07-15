<?php

$image = new Imagick( 
'uploads/coder.png'); 
  
// Charcoal Image function
// @params $radius $sigma
$image->charcoalImage(1, 5); 
   
header('Content-type: image/png'); 
  
// Display the output image 
echo $image;

?>