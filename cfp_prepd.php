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

include_once "./php/utils.php";
include_once "./php/postcodecheck.php";
// import the local config file
// require_once './db_php/config_local.php';

// import the production db config file
include_once './php/config.php';

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


    // tmep storage for sanitized form data (populate $formfields array with keys from the form)
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

    if (!preg_match("/^[a-zA-Z 0-9@#$']*$/",$cname)) {
        $cnameErr = "company Name: Only numbers, letters, @ # $ ' and white space allowed";
    }

    if (!preg_match("/^[a-zA-Z -]*$/",$ctype)) {
        $ctypeErr = "Company Type: Only selection from list is allowed";
    }

    if (!filter_var($cemail, FILTER_VALIDATE_EMAIL)) {
        $cemailErr = "Invalid email format should be like: something@somemail.com";
    }

    if ($msglen > 255) {
        $commentsErr = "Sorry, your message can only be 256 characters long";
    }

    /*#################### DATA VALIDATION ENDS HERE ####################*/

    // ECHO ERRORS encountered during validation
    if($fnameErr != "" || $lnameErr != "" || $useremailErr != "" || $postcodeErr != "" || $cnameErr || $ctypeErr || $cemailErr || $commentsErr != "" ) {
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
}



// ECHO DATA FROM `$FORMFIELDS` back to the user on error page
echo "<h1 >You gave me the following data:</h1><br>";

foreach($formfields as $v) {
    echo $v . "<br>";
}

// validation free of errors so redirect to thankyou page
// clear `$_SESSION` vars
// and redirect to thankyou page
if ($valid) {
    $_SESSION = [];
    $debug = false;
    if (!$debug) header('Location: formThankyou.php');
}

/*#################### DATABASE CONNECTION START HERE ####################*/
if ($valid) {

    // make new db connection
    $conn = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

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

$conn->close();

/*#################### DATABASE CONNECTION ENDS HERE ####################*/

// function to sanitize the input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  
?>

