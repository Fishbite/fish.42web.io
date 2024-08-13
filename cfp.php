<!-- CONTACT FORM PROCESSOR -->
<?php
session_start();

include_once "./php/utils.php";
include_once "./php/postcodecheck.php";
// import the local config file
require_once './php/config.php';

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


    // populate $formfields array with keys from the form
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
    
    $imglen = strlen($comments);

    // vars to hold error messages
    $fnameErr = $lnameErr = $useremailErr = $postcodeErr = $cnameErr = $ctypeErr = $cemailErr = $commentsErr = "";

    // Validate the data in all fields
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
        $useremailErr = "Invalid email format should be like: something@somemail.com";
    }

    // check user postcode is valid UK formatted postcode
    if(empty($postcode)) {
        $postcodeErr = "Postcode is required";
    } else if (!checkPostcode($postcode)) {
        $postcodeErr = "Invalid format of postcode";
    }

    if (!preg_match("/^[a-zA-Z 0-9@#$']*$/",$cname)) {
        $cnameErr = "company Name: Only numbers, letters, @#$ and white space allowed";
    }

    if (!preg_match("/^[a-zA-Z -]*$/",$ctype)) {
        $ctypeErr = "Company Type: Only selection from list is allowed";
    }

    if (!filter_var($cemail, FILTER_VALIDATE_EMAIL)) {
        $cemailErr = "Invalid email format should be like: something@somemail.com";
    }

    if ($imglen > 256) {
        $commentsErr = "Sorry, your message can only be 256 characters long";
    }

    // echo any errors encountered during validation
    if($fnameErr != "" || $lnameErr != "" || $useremailErr != "" || $postcodeErr != "" || $commentsErr != "" ) {
        $valid = false;
        echo "<strong>Oops! We have errors</strong><br><br>";
        echo htmlspecialchars($fnameErr)  . "<br>";
        echo htmlspecialchars($lnameErr) . "<br>";
        echo htmlspecialchars($useremailErr) . "<br>";
        echo htmlspecialchars($postcodeErr) . "<br>";
        echo htmlspecialchars($cnameErr) . "<br>";
        echo htmlspecialchars($ctypeErr) . "<br>";
        echo htmlspecialchars($cemailErr) . "<br>";
        echo htmlspecialchars($commentsErr) . "<br>";

        echo '<a href="contactform.php">back to form</a>';

    }

    // populate $formfields with sanitized data when no errors are present
    foreach($_POST as $k => $v) {
        $formfields[$k] = test_input($v);
    }
}



// test $formfields is populated with keys from the form
// and sanitized data
print_arr($formfields);

// validation free of errors so redirect to thankyou page
// clear `$_SESSION` vars
// and redirect to thankyou page
if ($valid) {
    $_SESSION = [];
    $debug = false;
    if (!$debug) header('Location: formThankyou.php');
}


if ($valid) {
    // DATABASE
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die('Connection failed: '. mysqli_connect_error());
} else {
    echo "Connected to $host & DB $dbname <br>";
}

$fname = mysqli_real_escape_string($conn, $formfields["fname"]);
echo "SQL escaped string 'fname from formields = $fname <br>";

$lname = mysqli_real_escape_string($conn, $formfields["lname"]);
echo "SQL escaped string 'lname from formfields = $lname <br>";

$useremail = mysqli_real_escape_string($conn, $formfields["useremail"]);

$postcode = mysqli_real_escape_string($conn, $formfields["postcode"]);

$cname = mysqli_real_escape_string($conn, $formfields["cname"]);

$ctype = mysqli_real_escape_string($conn, $formfields["ctype"]);

$cemail = mysqli_real_escape_string($conn, $formfields["cemail"]);

$comments = mysqli_real_escape_string($conn, $formfields["comments"]);


// SQL statement
$sql = "INSERT INTO contacts (firstname, lastname, useremail, postcode, companyname, companytype, companyemail, message) VALUES ('$fname', '$lname', '$useremail', '$postcode', '$cname', '$ctype', '$cemail', '$comments')";

// mysqli_query($conn, $sql);

if (mysqli_query($conn, $sql)) {
    echo "New contact added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

}

// function to sanitize the input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  
?>