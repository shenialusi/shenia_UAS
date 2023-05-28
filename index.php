<?php
	session_start();
	
	$conn = new mysqli('localhost', 'root', '', 'dbshenia');
	
	$unsuccessfulmsg = '';

	if(isset($_POST['submit'])){
		$user_email 		= strip_tags($_POST['user_email']);
		$user_password 		= strip_tags($_POST['user_password']);
		$passwordmd5 	    = md5($user_password);
		
		if(empty($user_email)){
			$emailmsg = 'Enter an email.';
		}else{
			$emailmsg = '';
		}
		
		if(empty($user_password)){
			$passmsg = 'Enter your password.';
		}else{
			$passmsg = '';
		}
		
		if(!empty($user_email) && !empty($user_password)){
			$sql = "SELECT * FROM tbuser WHERE user_email='$user_email' AND user_password = '$user_password'";
			$query = $conn->query($sql);
			
			if($query->num_rows > 0){
				$row = $query->fetch_assoc();
				$user_first_name = $row['user_first_name'];
				$user_last_name = $row['user_last_name'];
				
				$_SESSION['user_last_name'] = $user_last_name;
				$_SESSION['user_first_name'] = $user_first_name;
				header("location:crudsederhana.php");
			}else{
				$unsuccessfulmsg = 'Wrong email or Password';
			}
		}
	}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="container" style="margin-top:50px">
            <h3 class="text-center">LOGIN</h3>
            <p class="text-center text-success">
                <?php if(!empty($_SESSION['signupmsg'])){ echo $_SESSION['signupmsg']; } ?></p>
        </div>
        <div class="container" style="margin-top:50px">
            <div class="row">
                <div class="col-sm-4">

                </div>
                <div class="col-sm-4">
                    <div class="container bg-light p-4">
                        <p class="text-danger"><?php echo $unsuccessfulmsg ?> </p>
                        <form action="" method="POST">
                            <div class="mt-2 pb-2">
                                <label for="email">Email</label>
                                <input type="email" name="user_email" class="form-control"
                                    placeholder="Enter your email"
                                    value="<?php if(isset($_POST['submit'])){echo $user_email; } ?>">
                                <span class="text-danger"><?php if(isset($_POST['submit'])){ echo $emailmsg; }?></span>
                            </div>
                            <div class="mt-1 pb-2">
                                <label for="password">Password</label>
                                <input type="password" name="user_password" class="form-control"
                                    placeholder="Enter your password">
                                <span class="text-danger"><?php if(isset($_POST['submit'])){ echo $passmsg; }?></span>
                            </div>
                            <div class="mt-1 pb-2">
                                <button name="submit" class="btn btn-success">Login</button>
                            </div>
                            <div class="mt-1 pb-2">
                            Don't you have an account? <a href="signup.php" class="text-decoration-none">Sign Up</a>
                            </div>
                    </div>
                </div>
                <div class="col-sm-4">

                </div>
            </div>
        </div>
    </div>
</body>

</html>