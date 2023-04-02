<?php
require('database.php');
session_start();
// $email=$_SESSION['email'];
if(!ISSET($_SESSION['email'])){
    header('location:login.php');
}
$querysql="SELECT * from users where email='$_SESSION[email]'";
$temp=mysqli_query($conn, $querysql) or die ( mysqli_error());
$rowt=mysqli_fetch_assoc($temp);
$id=$rowt['id'];

$query = "DELETE FROM users WHERE id='$id'"; 
$result = mysqli_query($conn,$query) or die ( mysqli_error());
if($query){
    header("Location: reg.php"); 
    echo "DELETED PROFILE SUCCESSFULLY";
}

?>