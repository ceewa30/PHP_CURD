<?php
// Process delete operation after confirmation
if(isset($_GET["id"]) && !empty($_GET["id"])){
    // Include config file
    require_once 'DB_connection.php';
      echo $_GET["id"];
    // Prepare a delete statement
    $sql = "DELETE FROM emp_details WHERE emp_id = ?";

    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        // Set parameters
        $param_id = trim($_GET["id"]);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            echo "Records deleted successfully. Redirect to landing page";
            $sql = "SET @num := 0;";
            $sql .= "UPDATE emp_details SET emp_id = @num := (@num+1);";
            $sql .= "ALTER TABLE emp_details AUTO_INCREMENT =1";

            if(mysqli_multi_query($con, $sql)){
              //  echo "Records deleted successfully. Redirect to landing page";
            header("location: ../index.php");
            exit();
          }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($con);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
