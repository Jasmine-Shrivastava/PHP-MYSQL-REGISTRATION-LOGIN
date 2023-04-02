<?php
session_start();

include "database.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$cpassword = $_POST['cpassword']; 
$error=0;
// $pass=password_hash($password,PASSWORD_BCRYPT);   //encrypting password
// $cpass=password_hash($cpassword,PASSWORD_BCRYPT);
if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
$email_error = "Please Enter Valid Email ID";
$error=1;
}
if(strlen($password) < 6) {
$password_error = "Password must be minimum of 6 characters";
$error=1;
}       
if($password != $cpassword) {
$cpassword_error = "Password and Confirm Password doesn't match";
$error=1;
}


//checking if email exist in database or not
    $emailquery=  " select * from users where email='$email' limit 1 ";
    $query = mysqli_query($conn,$emailquery);
    
    //checking if that email exists more than once in db

    $emailcount = mysqli_num_rows($query);
    if($emailcount>0){
        $email_error= "Email already exists";
       $error=1;
    }
    
if ($error==0) {

     $pass=md5($password);//encrypting password
if(mysqli_query($conn, "INSERT INTO users (first_name, last_name,email,password) VALUES('$first_name','$last_name','$email','$pass')")) {
    
    header("location: home.php");
    $_SESSION['registered'] = true;
        $_SESSION['email'] = $email;
    $success="Registered succesfully";
exit();
} 
else {
echo "Error: " .  mysqli_error($conn);
echo "Insertion Unscuccessful";
}
}
else{
    echo "Error Found: ";
}
if (isset($success)) echo $success; 
mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Registration Form </title>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
<div class="row">
<div class="col-lg-8 col-offset-2">
<div class="page-header">
<h2>Register To Your Website</h2>
</div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="form-group">
<label>First_Name</label>
<input type="text" name="first_name" class="form-control" value="" maxlength="50" required="">
<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
</div>
<div class="form-group">
<label>Last_Name</label>
<input type="text" name="last_name" class="form-control" value="" maxlength="50" required="">
<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
</div>
<div class="form-group ">
<label>Email</label>
<input type="email" name="email" class="form-control" value="" maxlength="30" required="">
<span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
</div>
<div class="form-group">
<label>Password</label>
<input type="password" name="password" class="form-control" id="inpass" value="" maxlength="8" required="">
<input type="checkbox" onclick="myFunction()">Show Password
<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
</div>  
<div class="form-group">
<label>Confirm Password</label>
<input type="password" name="cpassword" class="form-control" value="" maxlength="8" required="">
<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
</div>
<input type="submit" class="btn btn-primary" name="signup" value="submit">


<script>
function myFunction() {
  var x = document.getElementById("inpass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
Already have a account?<a href="login.php" class="mt-3">  Login</a>

</form>
</div>
</div>    
</div>
</body>
</html>