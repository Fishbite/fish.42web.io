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
    $_SESSION["postcode"] = $_POST["postcode"];

    $fname = $_SESSION['fname'] = $_POST["fname"];
    $lname = $_SESSION['lname'] = $_POST["lname"];
    $useremail = $_SESSION['useremail'] = $_POST["useremail"];
    $postcode = $_SESSION['postcode'] = $_POST['postcode'];
    

    $fnameErr = $lnameErr = $useremailErr = $postcodeErr = "";

    // check first name
    if(empty($fname)) {
        $fnameErr = "First name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
        $fnameErr = "<strong>First Name: </strong>Only letters and white space allowed<br>";
    }


    // chack last name
    if(empty($lname)) {
        $lnameErr = "Last name is required";
    }else if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
        $lnameErr = "<strong>Last Name: </strong>Only letters and white space allowed<br>";
    }

    
    // check email address is well formed
    if(empty($useremail)) {
        $useremailErr = "Email is required";
    }
    if (!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        $useremailErr = "Invalid email format should be like: something@somemail.com";
    }

    // check postcode
    if (empty($postcode)) {
        $postcodeErr = "postcode is required";
    }else if (!checkPostcode($postcode)) {
        $postcodeErr = "Invalid postcode only letters & numbers allowed";
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

  //UK postcode validation check
// function isPostcodeValid($postcode)
// {
//     //remove all whitespace
//     $postcode = preg_replace('/\s/', '', $postcode);
 
//     //make uppercase
//     $postcode = strtoupper($postcode);
 
//     if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/",$postcode)
//         || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/",$postcode)
//         || preg_match("/^GIR0[A-Z]{2}$/",$postcode))
//     {
//         return true;
//     }
//     else
//     {
//         return false;
//     }
// }

// poscode validator function
function checkPostcode (&$toCheck) {
    // Permitted letters depend upon their position in the postcode.
    $alpha1 = "[abcdefghijklmnoprstuwyz]";                          // Character 1
    $alpha2 = "[abcdefghklmnopqrstuvwxy]";                          // Character 2
    $alpha3 = "[abcdefghjkpmnrstuvwxy]";                            // Character 3
    $alpha4 = "[abehmnprvwxy]";                                     // Character 4
    $alpha5 = "[abdefghjlnpqrstuwxyz]";                             // Character 5
    
    // Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
    $pcexp[0] = '/^('.$alpha1.'{1}'.$alpha2.'{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$/';
   
    // Expression for postcodes: ANA NAA
    $pcexp[1] =  '/^('.$alpha1.'{1}[0-9]{1}'.$alpha3.'{1})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$/';
   
    // Expression for postcodes: AANA NAA
    $pcexp[2] =  '/^('.$alpha1.'{1}'.$alpha2.'{1}[0-9]{1}'.$alpha4.')([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$/';
    
    // Exception for the special postcode GIR 0AA
    $pcexp[3] =  '/^(gir)(0aa)$/';
    
    // Standard BFPO numbers
    $pcexp[4] = '/^(bfpo)([0-9]{1,4})$/';
    
    // c/o BFPO numbers
    $pcexp[5] = '/^(bfpo)(c\/o[0-9]{1,3})$/';
    
    // Overseas Territories
    $pcexp[6] = '/^([a-z]{4})(1zz)$/i';
   
    // Load up the string to check, converting into lowercase
    $postcode = strtolower($toCheck);
   
    // Assume we are not going to find a valid postcode
    $valid = false;
    
    // Check the string against the six types of postcodes
    foreach ($pcexp as $regexp) {
    
      if (preg_match($regexp,$postcode, $matches)) {
              
        // Load new postcode back into the form element  
            $postcode = strtoupper ($matches[1] . ' ' . $matches [3]);
              
        // Take account of the special BFPO c/o format
        $postcode = preg_replace ('/C\/O/', '/c\/o /', $postcode);
        
        // Remember that we have found that the code is valid and break from loop
        $valid = true;
        break;
      }
    }
      
    // Return with the reformatted valid postcode in uppercase if the postcode was 
    // valid
    if ($valid){
        $toCheck = $postcode; 
          return true;
      } 
      else return false;
  }

?>