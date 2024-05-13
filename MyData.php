<?php 
$dsn = "mysql:host=localhost;dbname=mine" ; 
$user = "root" ;
$pass = "" ; 
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8" 
);
try {

    $conn = new PDO($dsn , $user , $pass , $option ); 
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION) ;
    include 'function.php';


}catch(PDOException $e){
  echo $e->getMessage() ;        
}