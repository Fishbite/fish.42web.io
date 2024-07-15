<!-- Upload file & copy to a specific folder -->
<?php
   echo "<strong>File to be uploaded: </strong>" . $_FILES["uploadfile"]["name"] . "<br>";
   echo "<strong>Type: </strong>" . $_FILES["uploadfile"]["type"] . "<br>";
   echo "<strong>File Size: </strong>" . $_FILES["uploadfile"]["size"]/1024 . "<br>";
   echo "<strong>Store in: </strong>" . $_FILES["uploadfile"]["name"] . "<br>";
   // print_r($_FILES);
   //    echo "server Root: " . $_SERVER['DOCUMENT_ROOT'] . "/home/vol2_8/infinityfree.com/if0_36002208/htdocs";

   if (file_exists($_FILES["uploadfile"]["name"])){
      echo "<h3>The file already exists</h3>";
   } else {
      $target = '../uploads/'.$_FILES["uploadfile"]["name"];
      if (file_exists($target)) {
         echo "file already exists, try renaming file and try again!";
         exit();
      } else {
      move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target) or die("Ugh! Could not copy file");
      echo "<h3>File Successfully Uploaded</h3>" . "<br>";
      echo "<img src='$target' width='100px'>" . "<br>";
   }}

   echo "<br>";
   echo  "<a href='/upload_img.html'><strong>Back</strong></a>". "<br>";
?>