<?php
// need this to output plain text to browser
// so that the "\n" is treated as a new line character!
header('Content-type: text/plain');
    $x = 10;
	$y = &$x;
	$z = $x+$y;
	echo "x=". $x . " y=" . $y . " z = " . $z . "\n";
	
	$y = 20;
	$z = $x+$y;
	echo "x=" . $x . " y=" . $y . " z =  " . $z . "\n";
	
	echo "\n";
	
	$x = array(
		"Hello World", false, 10.99,
		array(1=>10, 2=>20, 3=>30));
	var_dump($x);
	
	echo "\n";
	
	class Point {
      private $x;
      private $y;

      public function __construct(int $x, int $y = 0) {
         $this->x = $x;
         $this->y = $y;
      }
   }
	
	$p = new Point(4, 5);
	var_dump($p);
	
	echo "\n";
	echo "var_dump(get_defined_vars())\n";
	echo "\n";
	
	var_dump(get_defined_vars());
	
	echo "\n";
	
	$a = "good";
	$$a = "morning";
	
	echo "$a {$$a}\n";
	echo "$a $good\n";
	
	$fb = "foo";
	$$fb = "bar";
	echo 'value of $fb is ' . $fb . "\n";
	echo 'value of $$fb is ' . $$fb . "\n";
	echo 'value of $foo is ' .  $foo . "\n";
	
	echo "\n";
	
	 $php = "a";
     $lang = "php";
     $World = "lang";
     $Hello = "World";
     $a = "Hello";
	 
   echo '$a= ' . $a;
   echo "\n";
   echo '$$a= ' . $$a;
   echo "\n";
   echo '$$$a= ' . $$$a;
   echo "\n";
   echo '$$$$a= ' . $$$$a;
   echo "\n";
   echo '$$$$$a= ' . $$$$$a;
   echo "\n";

   $arr1 = [10, 20, 30, 40];
   $arr2 = array("Ten"=>10, "Twenty"=>20, "Thirty"=>30);

   var_dump($arr1[0]);
   var_dump($arr2["Twenty"]);

   echo "PHP version : " . phpversion() ."\n";
?>
