<?php
include 'MyData.php';
$username = filterRequest("username");
$password =filterRequest("password");

$conn = new mysqli( $username, $password);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = filterRequest("username");
$password = filterRequest("password");

$sql = "SELECT * FROM signup , providersignup  WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  
  echo json_encode(array('success' => true));
} else {
  echo json_encode(array('success' => false));
}

$conn->close();