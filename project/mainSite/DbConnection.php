<?php 

$server = 'localhost';
$dbname ='onlinestore';
$user ='root';
$pass ='ahmed';
// Create connection
$conn =  mysqli_connect($server,$user, $pass,$dbname);

// Check connection
if (! $conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>