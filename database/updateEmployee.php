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
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden input value

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
      $sql = "UPDATE emp_details SET emp_name=?, emp_email=?, emp_gender=?, emp_address=? WHERE emp_id=?";


if($stmt = mysqli_prepare($con, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssssi", $emp_name, $emp_email, $emp_gender, $emp_address, $emp_id);

    // Set parameters
    $emp_name = $emp_name;
    $emp_email = $emp_email;
    $emp_gender = $emp_gender;
    $emp_address = $emp_address;
    $emp_id = $_GET["id"];

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
      // echo "Records updated successfully. Redirect to landing page";
              header("location: ../index.php");
              exit();
    } else{
        echo "Something went wrong. Please try again later.";
    }
}

// Close statement
mysqli_stmt_close($stmt);
}
// Close connection
mysqli_close($con);
} else {
  // Check existence of id parameter before processing further
  if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

      // Prepare a select statement
      $sql = "SELECT * FROM emp_details WHERE emp_id = ?";

      if($stmt = mysqli_prepare($con, $sql)){
          // Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "i", $param_id);

          // Set parameters
          $param_id = trim($_GET["id"]);

          // Attempt to execute the prepared statement
          if(mysqli_stmt_execute($stmt)){
              $result = mysqli_stmt_get_result($stmt);

              if(mysqli_num_rows($result) == 1){

                  /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                  // Retrieve individual field value

                   $emp_name = $row['emp_name'];
                   $emp_email = $row['emp_email'];
                   $emp_gender = $row['emp_gender'];
                   $emp_address = $row['emp_address'];
              } else{
                  // URL doesn't contain valid id parameter. Redirect to error page
                  header("location: error.php");
                  exit();
              }

          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }
      }

      // Close statement
      mysqli_stmt_close($stmt);

      // Close connection
      mysqli_close($con);
  } else{
      // URL doesn't contain id parameter. Redirect to error page
      header("location: error.php");
      exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    	<link rel="stylesheet"
    	href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Include main CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Include jQuery library -->
    	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
          <!--[if lt IE 9]>
          <script src = "https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src = "https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
  </head>
  <body>
    <h3 class="text-center">Edit Employee Details</h3>
    <nav class="navbar navbar-default">
    <div class="navbar-header">
    <a href='../index.php' title='Back to Main Page' data-toggle='tooltip'><button class="btn btn-primary"><i class="fa fa-arrow-circle-o-left fa-lg" aria-hidden="true"></i>
    Back</button></a>
    </div>
    </nav>
    <!-- Form used to add new entries of employee in database -->
<form method="post" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"  class="form-horizontal alert alert-warning" name="empList">
<div class="form-group">
<label for="Name">Employee Name:</label>
<input type="text" name="emp_name" value="<?php echo $emp_name; ?>" class="form-control" placeholder="Enter Employee Name"/>
</div>
<div class="form-group">
<p class="text-danger">Name field is Empty!</p>
</div>
<div class="form-group">
<label for="Email">Email Address:</label>
<input type="email" name="emp_email" value="<?php echo $emp_email; ?>" class="form-control" placeholder="Enter Employee Email Address"/>
</div>
<div class="form-group">
<p class="text-danger">Invalid Email!</p>
</div>
<div class="form-group">
<label for="Gender">Gender:</label>
<label for="" class="radio-inline gender">
<input type="radio" name="emp_gender" value="male" <?php echo ($emp_gender == 'male')?'checked':''?> >Male
</label>
<label for="" class="radio-inline gender">
<input type="radio" name="emp_gender" value="female" <?php echo ($emp_gender == 'female')?'checked':''?> >Female
</label>
</div>
<div class="form-group">
<label for="Address">Address:</label>
<input type="text" name="emp_address" value="<?php echo $emp_address; ?>" class="form-control" placeholder="Enter Employee Address"/>
</div>
<div class="form-group">
<p class="text-danger">Address field is Empty!</p>
</div>
<div class="form-group">
<button class="btn btn-warning">Add Into Database</button>
</div>
</form>
  </body>
</html>
