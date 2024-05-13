<?php
include 'MyData.php';
$username = filterRequest("username");
$email = filterRequest("email");
$password = filterRequest("password");
$verfiy_code = rand(1,10000);
$conn = new mysqli( $username, $password, $email);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username =  filterRequest("username");
$email = filterRequest("email");
$password =  filterRequest("password");

$checkQuery = "SELECT * FROM signup WHERE username='$username'";
$checkQuery = "SELECT * FROM signup WHERE username='$email'";
$checkQuery = "SELECT * FROM signup WHERE username='$password'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
  echo json_encode(array('success' => false, 'message' => 'Username or Email already exists'));
} else {
  $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email','$password')";
  if ($conn->query($insertQuery) === TRUE) {
    echo json_encode(array('success' => true));
  } else {
    echo json_encode(array('success' => false, 'message' => 'Error registering user'));
  }
}


$conn->close();
