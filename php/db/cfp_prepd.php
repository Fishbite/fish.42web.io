<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <link rel="stylesheet" href="./styles/styles.css">
</head>
<body class="err">
    
</body>
</html>

<!-- CONTACT FORM PROCESSOR -->
<?php
session_start();

include_once "../lib/utils.php";
include_once "../lib/postcodecheck.php";

// import the local config file
// enable this for development / debugging locally
// require_once '../../db_php/config_local.php';

// import the production db config file
// enable this for production
include_once '../lib/config.php';

// assume input is valid:
$valid = true;
$debug = false; 


// echo "Hello! Just testing everything's OK!<br>";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // echo "POSTED!!!!<br>";

    // check if form is completely empty i.e. user hit submit btn by mistake
    // this is the safe way to consider 0 or "0" as not empty
    if (strlen(implode($_POST)) == 0) {
        header("Location: contactform.php", true, 301);
        echo "Form is empty";
        exit();
    }
    // else process the form.....

    // check for spambots
    $honeypot = FALSE;
    if (!empty($_POST['a_password'])) {
    $honeypot = TRUE;
    # treat as spambot
    htmlentities(error_log('possible spambot detected ' . date("F j, Y, g:i a").PHP_EOL, 3, '../tmp/sb_err.log')) ;
    // send bot to eternal hell
    header("location: http://www.monkeys.com/wpoison/", true, 301);
    exit();
    }

    
    // temp storage for sanitized form data (populate $formfields array with keys from the form)
    $formfields = [];

    // set global & `SESSION` vars to use in `contactform.view.php`
    // values retrieved from form upload

    if (isset($_POST["fname"])) $fname = $_SESSION['fname'] = $_POST["fname"];
    if (isset($_POST["lname"])) $lname = $_SESSION['lname'] = $_POST["lname"];
    if (isset($_POST["useremail"])) $useremail = $_SESSION["useremail"] = $_POST["useremail"];
    if (isset($_POST["postcode"])) $postcode = $_SESSION["postcode"] = $_POST["postcode"];
    // company details
    if (isset($_POST["cname"])) $cname = $_SESSION["cname"] = $_POST["cname"];
    if (isset($_POST["ctype"])) $ctype = $_SESSION["ctype"] = $_POST["ctype"];
    
    if (isset($_POST["cemail"])) $cemail = $_SESSION["cemail"] = $_POST["cemail"];
    if (isset($_POST["comments"])) $comments = $_SESSION["comments"] = $_POST["comments"];
    
    $msglen = strlen($comments);

    // vars to hold error messages
    $fnameErr = $lnameErr = $useremailErr = $postcodeErr = $cnameErr = $ctypeErr = $cemailErr = $commentsErr = "";

    /*#################### DATA VALIDATION STARTS HERE ####################*/
    // VALIDATE THE DATA in all fields: check if required fields are empty
    // then check the entered data

    // check first name
    if(empty($fname)) {
        $fnameErr = "First name is required";
        
    }else if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        $fnameErr = "First Name: Only letters and white space allowed";
    }

    // check last name
    if(empty($lname)) {
        $lnameErr = "Last name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        $lnameErr = "Last Name: Only letters and white space allowed";
    }

    
    // check user email address is well formed
    if(empty($useremail)) {
        $useremailErr = "Email is required";
    } else if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $useremailErr = "Invalid email format should be something like: you@somemail.com";
    }

    // check user postcode is valid UK formatted postcode
    if(empty($postcode)) {
        $postcodeErr = "Postcode is required";
    } else if (!checkPostcode($postcode)) {
        $postcodeErr = "Invalid format of postcode";
    }

    if(!empty($cname)){
        if (!preg_match("/^[a-zA-Z 0-9@#$']*$/",$cname)) {
            $cnameErr = "company Name: Only numbers, letters, @ # $ ' and white space allowed";
        }
    }
    
    if(!empty($ctype)) {
        if (!preg_match("/^[a-zA-Z -]*$/",$ctype)) {
            $ctypeErr = "Company Type: Only selection from list is allowed";
        }
    }

    if (!empty($cemail)) {
        if (!filter_var($cemail, FILTER_VALIDATE_EMAIL)) {
            $cemailErr = "Invalid email format should be like: something@somemail.com";
        }
    }

    if (!empty($comment)) {
        if ($msglen > 255) {
            $commentsErr = "Sorry, your message can only be 256 characters long";
        }
    }

    /*#################### DATA VALIDATION ENDS HERE ####################*/

    // ECHO ERRORS encountered during validation
    if($fnameErr != "" || $lnameErr != "" || $useremailErr != "" || $postcodeErr != "" ||  $cnameErr != "" || $ctypeErr != "" || $cemailErr != ""|| $commentsErr != "") {
        $valid = false;
        echo "<h1>Oops! We have errors</h1><br><br>";
        echo htmlspecialchars($fnameErr)  . "<br>";
        echo htmlspecialchars($lnameErr) . "<br>";
        echo htmlspecialchars($useremailErr) . "<br>";
        echo htmlspecialchars($postcodeErr) . "<br>";
        echo htmlspecialchars($cnameErr) . "<br>";
        echo htmlspecialchars($ctypeErr) . "<br>";
        echo htmlspecialchars($cemailErr) . "<br>";
        echo htmlspecialchars($commentsErr) . "<br>";

        echo '<a class="err-link" href="contactform.php">back to form</a>';

    }

    // POPULATE $FORMFIELDS with sanitized data when no errors are present
    foreach($_POST as $k => $v) {
        $formfields[$k] = test_input($v);
    }

    // print_arr($formfields);
}



// ECHO DATA FROM `$FORMFIELDS` back to the user on error page
echo "<h1 >You gave me the following data:</h1><br>";

// the honey trap is the 4th field on the form, so skip printing that field
// if we need to move the honey trap, change `if ($arrayIndexCount === 3)`
$arrayIndexCount = 0;
foreach($formfields as $k => $v) {
    
    if ($arrayIndexCount === 3) {
        next($formfields);
    } else {
        echo $v . '<br>';
    }

    $arrayIndexCount++;
}

// validation free of errors so redirect to thankyou page
// clear `$_SESSION` vars
// and redirect to thankyou page
if ($valid) {
    $_SESSION = []; // comment this out to keep user entered data in UI form
    $debug = false; // set to true to debug
    if (!$debug) header('Location: ../../formThankyou.php');
}

/*#################### DATABASE CONNECTION START HERE ####################*/
if ($valid) {

    // make new db connection to production server
    // enable this for production
    $conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    // make new db connection to local test server
    // disable this for production
    // $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // test connection
    if ($conn->connect_error) {
        die("Oh! Pants! Can't connect for some reason :-( " . $conn-> connect_error);
    }

    // prepare an SQL statement then bind parameters
    $stmt = $conn->prepare("INSERT INTO contacts (firstname, lastname, useremail, postcode, companyname, companytype, companyemail, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
    //  bind parameters
    $stmt->bind_param("ssssssss", $fname, $lname, $useremail, $postcode, $cname, $ctype, $cemail, $comments);

    // set the values for the prepared statement's parameters
    // note that we are escaping each string value
    if (isset($formfields)) {
        $fname = mysqli_real_escape_string($conn, $formfields["fname"]);
        $lname = mysqli_real_escape_string($conn, $formfields["lname"]);
        $useremail = mysqli_real_escape_string($conn, $formfields["useremail"]);
        $postcode = mysqli_real_escape_string($conn, $formfields["postcode"]);
        $cname = mysqli_real_escape_string($conn, $formfields["cname"]);
        $ctype = mysqli_real_escape_string($conn, $formfields["ctype"]);
        $cemail = mysqli_real_escape_string($conn, $formfields["cemail"]);
        $comments = mysqli_real_escape_string($conn, $formfields["comments"]);
        $stmt->execute();
    }

}
// set `$_SESSION` vars to loop through on formThankyou.view.php
if(isset($fname)) {$_SESSION['firstname'] = $fname;}
if(isset($lname)){$_SESSION['lastname'] = $lname;}
if (isset($useremail)){$_SESSION['email'] = $useremail;}
if (isset($postcode)){$_SESSION['postcode'] = $postcode;}
if (isset($cname) && $cname != "") {$_SESSION['company name'] = $cname;}
if (isset($ctype) && $ctype != "") {$_SESSION['company type'] = $ctype;}
if (isset($cemail) && $cemail != "") {$_SESSION['company email'] = $cemail;}
if (isset($comments) && $comments != "") {$_SESSION["message"] = $comments;}

if ($conn) $conn->close();
// $conn->close(); // this can cause problems!!!

/*#################### DATABASE CONNECTION ENDS HERE ####################*/

// function to sanitize the input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  
?>

