<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "DB_connection.php";
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
    <h3 class="text-center">Employee Details</h3>
    <nav class="navbar navbar-default">
    <div class="navbar-header">
    <a href='../index.php' title='Back to Main Page' data-toggle='tooltip'><button class="btn btn-primary"><i class="fa fa-arrow-circle-o-left fa-lg" aria-hidden="true"></i>
    Back</button></a>
    </div>
    </nav>
    <!-- Form used to add new entries of employee in database -->
<form method="post" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"  class="form-horizontal alert alert-warning" name="empList" id="empForm">
<div class="form-group">
<label for="Name">Employee Name:</label>
<input type="text" name="emp_name" disabled value="<?php echo $emp_name; ?>" class="form-control" placeholder="Enter Employee Name"/>
</div>
<div class="form-group">
<label for="Email">Email Address:</label>
<input type="email" name="emp_email" disabled value="<?php echo $emp_email; ?>" class="form-control" placeholder="Enter Employee Email Address"/>
</div>
<div class="form-group">
<label for="Gender">Gender:</label>
<label for="" class="radio-inline gender">
<input type="radio" name="emp_gender" value="male" disabled <?php echo ($emp_gender == 'male')?'checked':''?> >Male
</label>
<label for="" class="radio-inline gender">
<input type="radio" name="emp_gender" value="female" disabled <?php echo ($emp_gender == 'female')?'checked':''?> >Female
</label>
</div>
<div class="form-group">
<label for="Address">Address:</label>
<input type="text" name="emp_address" disabled value="<?php echo $emp_address; ?>" class="form-control" placeholder="Enter Employee Address"/>
</div>
<div class="form-group">
<button class="btn btn-warning" disabled>Add Into Database</button>
</div>
</form>
  </body>
</html>
