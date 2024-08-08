<!-- CONTACT FORM PROCESSOR -->
<?php
session_start();

include "php/utils.php";
include_once "php/postcodecheck.php";

// assume input is valid:
$valid = true;


// echo "Hello! Just testing everything's OK!<br>";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // echo "POSTED!!!!<br>";

    // check if form is empty
    // this is the safe way to consider 0 or "0" as not empty
    if (strlen(implode($_POST)) == 0) {
        header("Location: contactform.php", true, 301);
        echo "Form is empty";
        exit();
    }
    // else process the form.....


    // populate $formfields array with keys from the form
    // $formfields = array_fill_keys(array_keys($_POST), null);

    // set global & `SESSION` vars to use in `contactform.view.php`
    // values retrieved from form upload

    if (isset($_POST["fname"])) $fname = $_SESSION['fname'] = $_POST["fname"];
    if (isset($_POST["lname"])) $lname = $_SESSION['lname'] = $_POST["lname"];
    if (isset($_POST["useremail"])) $useremail = $_SESSION["useremail"] = $_POST["useremail"];
    if (isset($_POST["postcode"])) $postcode = $_SESSION["postcode"] = $_POST["postcode"];

    

    $fnameErr = $lnameErr = $useremailErr = $postcodeErr = "";

    // check first name
    if(empty($fname)) {
        $fnameErr = "First name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        $fnameErr = "First Name: Only letters and white space allowed";
    }


    // validate the data in each field
    // chack last name
    if(empty($lname)) {
        $lnameErr = "Last name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        $lnameErr = "Last Name: Only letters and white space allowed";
    }

    
    // check email address is well formed
    if(empty($useremail)) {
        $useremailErr = "Email is required";
    } else if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $useremailErr = "Invalid email format should be like: something@somemail.com";
    }

    // check postcode is valid UK formatted postcode
    if(empty($postcode)) {
        $postcodeErr = "Postcode is required";
    } else if (!checkPostcode($postcode)) {
        $postcodeErr = "Invalid format of postcode";
    }

    // 
    if($fnameErr !="" || $lnameErr !="" || $useremailErr !="" || $postcodeErr != "") {
        $valid = false;
        echo "<strong>Oops! We have errors</strong><br><br>";
        echo htmlspecialchars($fnameErr)  . "<br>";
        echo htmlspecialchars($lnameErr) . "<br>";
        echo htmlspecialchars($useremailErr) . "<br>";
        echo htmlspecialchars($postcodeErr) . "<br>";

        echo '<a href="contactform.php">back to form</a>';

    }

    // populate $formfields with sanitized data
    foreach($_POST as $k => $v) {
        $formfields[$k] = test_input($v);
    }
}



// test $formfields is populated with keys from the form
// and sanitized data
print_arr($formfields);

// validation free of errors so redirect to thankyou page
if ($valid) {
    $_SESSION = [];
    header('Location: formThankyou.php');
}

// sanitize the input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  
?>