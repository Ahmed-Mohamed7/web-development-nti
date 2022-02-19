<?php 
session_start();

$server = 'localhost';
$dbname ='blog';
$user ='root';
$pass ='ahmed';
// Create connection
$conn =  mysqli_connect($server,$user, $pass,$dbname);

// Check connection
if (! $conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>