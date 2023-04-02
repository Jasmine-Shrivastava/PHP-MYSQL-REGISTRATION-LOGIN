<?php 
   session_start();
    require_once("database.php");

	if(!ISSET($_SESSION['loggedin'])){
		header('location:login.php');
	}
    

    $query = " select * from users where email='$_SESSION[email]' ";
    
    $result = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>View Details</title>
</head>
<body class="bg-dark">

        <div class="container">
       
            <div class="row">
                <div class="col m-auto">
                    <div class="card mt-5">
                        <table class="table table-bordered">
                            <tr>
                                <td> First Name </td>
                                <td> Last Name </td>
                                <td> Email </td>
                                <td> Edit  </td>
                                <td> Delete </td>
                            </tr>
                            <?php 
                                    while($row=mysqli_fetch_assoc($result))
                                    {
                                        $Firstname = $row['first_name'];
                                        $Lastname = $row['last_name'];
                                        $Email = $row['email'];
                                        
                            ?>
                                    <tr>
                                        <td><?php echo $Firstname ?></td>
                                        <td><?php echo $Lastname ?></td>
                                        <td><?php echo $Email ?></td>
                                        <td><a href="update.php">Update</a></td>
                                        <td><a href="delete.php">Delete</a></td>
                                    </tr>        
                            <?php 
                                    }  
                            ?>                                                                      

                        </table>
                    </div>
                </div>
            </div>
            <a href="logout.php" class="btn btn-primary" text-align=center>Log Out</a>          
        </div>
</body>
</html>