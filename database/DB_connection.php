<?php
// Connecting to database as mysqli_connect("hostname", "username", "password", "database name");
$con = mysqli_connect("localhost", "root", "", "employee");
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
