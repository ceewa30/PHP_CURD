<?php
// Including database connections
require_once 'DB_connection.php';

// Define variables and initialize with empty values
$emp_name = $emp_email = $emp_gender = $emp_address = "";
$emp_name_err = $emp_email_err = $emp_gender_err = $emp_address_err = "";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate employee name
    $input_name = test_input($_POST["emp_name"]);
    if(empty($input_name)){
        $emp_name_err = "Please enter a employee name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $emp_name_err = "Please enter a valid employee name.";
    } else{
        $emp_name = $input_name;
    }
    // Validate employee email
    $input_email = test_input($_POST["emp_email"]);
    if(empty($input_email)){
        $emp_email_err = "Please enter a employee name.";
    } elseif(!filter_var($input_email, FILTER_VALIDATE_EMAIL)){
        $emp_email_err = "Please enter a valid employee name.";
    } else{
        $emp_email = $input_email;
    }
    // Validate gender
    $input_gender = test_input($_POST["emp_gender"]);
    if(empty($input_gender)){
        $emp_gender_err = "Please enter a gender.";
    } elseif(!filter_var($input_gender, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $emp_gender_err = "Please enter a valid gender.";
    } else{
        $emp_gender = $input_gender;
    }
    // Validate address
    $input_address = test_input($_POST["emp_address"]);
    if(empty($input_address)){
        $emp_address_err = "Please enter an employee address.";
    } else{
        $emp_address = $input_address;
    }

    if(empty($emp_name_err) && empty($emp_email_err) && empty($emp_gender_err) && empty($emp_address_err)){
// Prepare an insert statement
$sql = "INSERT INTO emp_details (emp_name, emp_email, emp_gender, emp_address) VALUES (?, ?, ?, ?)";


if($stmt = mysqli_prepare($con, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssss", $emp_name, $emp_email, $emp_gender, $emp_address);

    // Set parameters
    $emp_name = $emp_name;
    $emp_email = $emp_email;
    $emp_gender = $emp_gender;
    $emp_address = $emp_address;

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not execute query: $sql. " . mysqli_error($con);
    }
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($con);
}

// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($con);
}
}
?>
