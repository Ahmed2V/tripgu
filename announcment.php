<?php
include 'MyData.php';
$name = filterRequest("name");
$date = filterRequest("date");
$time = filterRequest("time");
$triplocation =  filterRequest("triplocation");
$overview = filterRequest("overview");
$moreinfo = filterRequest("moreinfo");

$conn = new mysqli( $name,$date,$time,$triplocation,$overview,$moreinfo);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $name = filterRequest("name");
$date = filterRequest("date");
$time = filterRequest("time");
$triplocation =  filterRequest("triplocation");
$overview = filterRequest("overview");
$moreinfo = filterRequest("moreinfo");

$sql= "SELECT * FROM announcment WHERE  name = '$name', date=`$date`, time=`$time`, triplocation=`$triplocation`, overview=`$overview`, moreinfo=`$moreinfo`)";
$result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
  
    echo json_encode(array('success' => true));
    $insertQuery = "INSERT INTO announcment (`name`, `date`, `time`, `triplocation`, `overview`, `moreinfo`) VALUES (`$name`,  `$date`, `$time`, `$triplocation`, `$overview`, `$moreinfo`)"; 
  } else {
    echo json_encode(array('success' => false));
  }
  
  $conn->close();
 
