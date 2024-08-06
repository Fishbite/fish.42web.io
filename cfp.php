<!-- CONTACT FORM PROCESSOR -->
<?php
session_start();

include "./php/utils.php";


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

    // TODO validate the data in each field

    $_SESSION['fname'] = $_POST["fname"];
    $_SESSION['lname'] = $_POST["lname"];
    $_SESSION["useremail"] = $_POST["useremail"];

    $fname = $_SESSION['fname'] = $_POST["fname"];
    $lname = $_SESSION['lname'] = $_POST["lname"];
    $useremail = $_SESSION['useremail'] = $_POST["useremail"];
    

    $fnameErr = $lnameErr = $useremailErr = "";

    // check first name
    if(empty($fname)) {
        $fnameErr = "First name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        $fnameErr = "First Name: Only letters and white space allowed";
    }


    // chack last name
    if(empty($lname)) {
        $lnameErr = "Last name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        $lnameErr = "Last Name: Only letters and white space allowed";
    }

    
    // check email address is well formed
    if(empty($useremail)) {
        $useremailErr = "Email is required";
    }
    if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $useremailErr = "Invalid email format should be like: something@somemail.com";
    }

    if($fnameErr !="" || $lnameErr !="" || $useremailErr !="") {
        echo "<strong>Oops! We have errors</strong><br><br>";
        echo htmlspecialchars($fnameErr)  . "<br>";
        echo htmlspecialchars($lnameErr) . "<br>";
        echo htmlspecialchars($useremailErr) . "<br>";

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

// sanitize the input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>