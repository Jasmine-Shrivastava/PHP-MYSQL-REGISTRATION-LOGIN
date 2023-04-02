<?php 
session_start();
require_once("database.php");
if(!ISSET($_SESSION['email'])){
    header('location:login.php');
}
$querysql="SELECT * from users where email='$_SESSION[email]'";
$temp=mysqli_query($conn, $querysql) or die ( mysqli_error());
$rowt=mysqli_fetch_assoc($temp);
$id=$rowt['id'];
// echo "$id";

  
  $findresult = mysqli_query($conn, "SELECT * FROM users WHERE id= '$id'");
if($res = mysqli_fetch_array($findresult))
{

$oldfirst_name = $res['first_name'];   
$oldlast_name = $res['last_name'];  
$oldemail = $res['email'];  
$oldpassword= $res['password'];

}
 ?> 
 <!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
           
     <form action="" method="POST" enctype='multipart/form-data'>
  <div class="login_form">
  
<?php 
 $password = "";
 $querysql="SELECT * from users where email='$_SESSION[email]'";
$temp=mysqli_query($conn, $querysql) or die ( mysqli_error());
$rowt=mysqli_fetch_assoc($temp);
$id=$rowt['id'];


  if($_SERVER['REQUEST_METHOD']==='POST'){
    
    $first_name= mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
     $email=mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $cpassword =$_POST['cpassword'];
    $pass=md5($password);   //encrypting password
    // $pass=password_hash($password,PASSWORD_BCRYPT);

$sql="SELECT * from users where id='$id'";
      $res=mysqli_query($conn,$sql);
   if (mysqli_num_rows($res) > 0) {
$row = mysqli_fetch_assoc($res);
$error=0;
   if($oldemail!=$email){
     if($email==$row['email'])
     {
           $email_error ='Email already Exists. Enter other one';
          } 
   }
   if($password!=$cpassword) {$cpassword_error ="Password and Confirm Password doesn't match";
$error=1;}
   if(strlen($password) < 6) {
    // $error[] = "Password must be minimum of 6 characters";
    $password_error = "Password must be minimum of 6 characters";
    $error=1;
   }
}
    if($error==0){ 
          
           $result1 = mysqli_query($conn,"UPDATE users SET first_name='$first_name',last_name='$last_name',email ='$email' ,password = '$pass' WHERE id='$id'");
          // $result2=mysqli_query($conn,"UPDATE users SET password='$password' where email='$oldemail'");
           if($result1)
           {
       header("location:login.php?profile_updated=1");
       echo "updated Successfully!!";
           }
           else 
           {
            echo "Something went wrong";
           }

    }
    if($error==1) {
        echo "Error Found: ";
    }
   
        }
        
//         if(isset($error)){ 

// foreach($error as $error){ 
//   echo '<p class="errmsg">'.$error.'</p>'; 
// }
// }


        ?> 
     <form method="post" enctype='multipart/form-data' action="">
     <h1 class="text-center">UPDATE YOUR PROFILE</h1>
          <div class="row">
            <div class="col"></div>
           <div class="col-6"> 
            
           </div>
           
          </div>

          <div class="form-group">
          <div class="row"> 
            <div class="col-3">
                <label>First Name</label>
            </div>
             <div class="col">
                <input type="text" name="first_name" value="<?php echo $oldfirst_name;?>" class="form-control">
            </div>
          </div>
      </div>

      <div class="form-group">
 <div class="row"> 
            <div class="col-3">
                <label>Last Name</label>
            </div>
             <div class="col">
                <input type="text" name="last_name" value="<?php echo $oldlast_name;?>" class="form-control">
            </div>
          </div>
      </div>

      <div class="form-group">
 <div class="row"> 
            <div class="col-3">
                <label>Email</label>
            </div>
             <div class="col">
                <input type="text" name="email" value="<?php echo $oldemail;?>" class="form-control">
                <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
            </div>
          </div>
      </div>
     
      <div class="form-group">
 <div class="row"> 
            <div class="col-3">
                <label>Password</label>
            </div>
             <div class="col">
                <input type="password" name="password" value="<?php echo $oldpassword;?>" class="form-control">
                <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
            </div>
          </div>
      </div>


      <div class="form-group">
 <div class="row"> 
            <div class="col-3">
                <label>Confirm Password</label>
            </div>
             <div class="col">
                <input type="password" name="cpassword" value="" class="form-control">
                <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
            </div>
          </div>
      </div>

           <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
<button type="submit" class="btn btn-primary" name="update_profile">Save Profile</button>
            </div>
           </div>
       </form>
        </div>
        <div class="col-sm-3">
        </div>
    </div>
</div> 

</body>

</html>