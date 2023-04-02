<?php
session_start();
include 'database.php';
$login = false;
$showError = false;
if(isset($_POST['login'])){
    
    
    $email = $_POST["email"];
    $password = $_POST["password"]; 

//    $passh=password_hash($password,PASSWORD_BCRYPT);
     $passh=md5($password);
    
    $sql = "Select * from users where email='$email' and password='$passh'";
    $result = mysqli_query($conn, $sql);
     
    //counting number of rows for entered info
    $num = mysqli_num_rows($result);
    
    //if it's matching with one row then do these things
    if ($num == 1){
            
        $login = true;
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("location: home.php");

        }
    else{
        $showError = "Invalid Credentials";
    }
    
}
?>

<!doctype html>
<html lang="en">
  <head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
    
    <?php
    if($login){
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> You are logged in
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }

    if($showError){
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
    ?>

    <div class="container my-4">
     <h1 class="text-center">Login to our website</h1>
     <form action="login.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="passlog" name="password">
            <input type="checkbox" onclick="myFunction()">Show Password
        </div>
       
         
        <button type="submit" name="login" class="btn btn-primary">Login</button>
        <br>
        Don't have account?<a href="reg.php" class="mt-3">Click Here</a>

        <script>
function myFunction() {
  var x = document.getElementById("passlog");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
     </form>
    </div>

    
  </body>
</html>
