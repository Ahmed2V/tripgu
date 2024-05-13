<?php
include 'MyData.php';
$username = filterRequest("username");
$email = filterRequest("email");
$password = filterRequest("password");
$address =  filterRequest("address");
$number = filterRequest("number");
$conn = new mysqli( $username, $password, $address,$number,$email);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username =  filterRequest("username");
$email = filterRequest("email");
$password =  filterRequest("password");
$address =  filterRequest("address");
$number = filterRequest("number");

$checkQuery = "SELECT * FROM providersignup WHERE username='$username'";
$checkQuery = "SELECT * FROM providersignup WHERE username='$email'";
$checkQuery = "SELECT * FROM providersignup WHERE username='$number'";
$checkQuery = "SELECT * FROM providersignup WHERE username='$address'";
$checkQuery = "SELECT * FROM providersignup WHERE username='$password'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {
  echo json_encode(array('success' => false, 'message' => 'Username or Email already exists'));
} else {
  $insertQuery = "INSERT INTO providersignup (username,email password,address,number) VALUES ('$username', '$email','$password','$address','$number')";
  if ($conn->query($insertQuery) === TRUE) {
    echo json_encode(array('success' => true));
  } else {
    echo json_encode(array('success' => false, 'message' => 'Error registering user'));
  }
}


$conn->close();
