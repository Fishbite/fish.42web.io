<?php
require 'utils.php';

   if( isset($_POST["name"]) || isset($_POST["age"]) ) {
      if (preg_match("/[^A-Za-z'-]/",$_POST['name'] )) {
         die ("invalid name, name should be alpha");
      }
    //   print_arr($_POST). "<br />";
      echo "Welcome ". $_POST['name']. "<br />";
      echo "You are ". $_POST['age']. " years old." . "<br />";

      $url = "../test_form.html";
      $text = "Back to Test_Form";
      echo "<a href='$url'>$text</a>";
      

      echo "\n";
      echo "\n";
      // print the associative array that can be used to get
      // the result from form data sent with GET or POST
      print_arr($_REQUEST);
      
      exit();
   }
?>