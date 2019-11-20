<?php
// Include config file
require_once 'database/DB_connection.php';

// Attempt select query execution
$sql = "SELECT * FROM emp_details";
if($result = mysqli_query($con, $sql)){
    if(mysqli_num_rows($result) > 0){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Basic CURD Demo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
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
</head>
<body>
<div class="container wrapper">
<h1 class="text-center">Basic CURD PHP</h1>
<nav class="navbar navbar-default">
<div class="navbar-header">
<div class="alert alert-default navbar-brand search-box">
<a href='template/form.html' title='Insert Record' data-toggle='tooltip'><button class="btn btn-primary">Add Employee <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button></a>
</div>
</div>
</nav>
<div class="clearfix"></div>

<!-- Table to show employee detalis -->
<div class="table-responsive">
<table class="table table-hover">
<tr>
<th>Emp ID</th>
<th>Employee Name</th>
<th>Email Address</th>
<th>Gender</th>
<th>Address</th>
<th colspan="3">Action</th>
</tr>
<?php while($row = mysqli_fetch_array($result)){ ?>
<tr>
<td>
<span><?=$row['emp_id']; ?></span></td>
<td><?=$row['emp_name']; ?></td>
<td><?=$row['emp_email']; ?></td>
<td><?=$row['emp_gender']; ?></td>
<td><?=$row['emp_address']; ?></td>
<td>
<!-- <button class="btn btn-warning" title="Edit"><span class="glyphicon glyphicon-edit"></span></button> -->
<a href='database/viewEmployee.php?id=<?=htmlspecialchars($row['emp_id']); ?>' title='View Record' data-toggle='tooltip'><i class="fa fa-eye text-primary"></i></a>
</td>
<td>
<!-- <button class="btn btn-warning" title="Edit"><span class="glyphicon glyphicon-edit"></span></button> -->
<a href='database/updateEmployee.php?id=<?=htmlspecialchars($row['emp_id']); ?>' title='Update Record' data-toggle='tooltip'><i class="fa fa-edit text-warning"></i></a>
</td>
<td>
<!-- <button class="btn btn-danger" title="Delete"><span class="glyphicon glyphicon-trash"></span></button> -->
<a href='database/deleteEmployee.php?id=<?=htmlspecialchars($row['emp_id']); ?>' title='Delete Record' data-toggle='tooltip'><i class="fa fa-trash text-danger"></i></a>
</td>
</tr>
<?php
} ?>
</table>
<?php
mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
                    }

                    // Close connection
                    mysqli_close($con);
                    ?>
</div>
</div>
</body>
</html>
