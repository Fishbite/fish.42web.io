<?php 
// import the local config file
require_once 'config_local.php';

echo"connection file loaded <br>";


$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die('Connection failed: '. mysqli_connect_error());
} else {
    echo "Connected to $host & DB $dbname";
}


?>