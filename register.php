<?php 
    require("templates/databaseConnection.php");
    $currentPage = "Registration";
    if($_POST){
		extract($_POST);
		$errors = array();

		if(!$username){
			array_push($errors, "Please enter a username");
		} else if(strlen($username) < 3){
			array_push($errors, "Please enter more than 3 characters into the username");
		} else if(strlen($username) > 50){
			array_push($errors, "Cant be more than 50 characters");
		}
		if(!$email){
			array_push($errors, "Please enter an email");
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			array_push($errors, "InValid email address");
		}
		if(!$password){
			array_push($errors, "Please enter a password");
		}
        if(!$passwordC){
			array_push($errors, "Please confirm the password");
		}
        if ($password != $passwordC) {
            array_push($errors, "The two passwords do not match");
        }
       // user already exist
        $sql = "SELECT * FROM registration WHERE username='$username' OR email='$email'";
        $result = mysqli_query($dbc, $sql);
        $user = mysqli_fetch_array($result);
        if ($user) { // if user exists
          if ($user['username'] === $username) {
          array_push($errors, "Username already exists");
          }
          if ($user['email'] === $email) {
          array_push($errors, "email already exists");
           }
        }
		else {
           if(empty($errors)){
			$username = mysqli_real_escape_string($dbc, $username);
			$email = mysqli_real_escape_string($dbc, $email);
			$password = mysqli_real_escape_string($dbc, $password);
            $password =md5($password);
			$sql = "INSERT INTO `registration` VALUES (NULL,'$username','$email','$password')";
			$result = mysqli_query($dbc, $sql);
			if($result && mysqli_affected_rows($dbc) > 0){
				session_start();
				$user_id = mysqli_insert_id($dbc); // Get the ID of the last inserted row.
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $username;
				header("Location:index.php");
				exit();
		   	} else{
		   		  die("Something went wrong, you can't register");
				}
			}
        }
    }
?>
<!DOCTYPE html>
<html>
     <head>
          <title>Registration </title>
          <link rel="stylesheet" type="text/css" href="style.css">
     </head>
     <body>
          <div class="header">
             <h2>Register</h2> 
          </div>
          <?php if($_POST): ?>
		      <div class="error">
			     <ul>
				     <?php foreach($errors as $singleError): ?>
					 <li><?= $singleError; ?></li>
				     <?php endforeach; ?>
			     </ul>
		      </div>
		  <?php endif; ?>
          <form method="post" action="register.php"autocomplete="off">
  	         <div class="input-group">
  	             <label>Username</label>
  	             <input type="text" name="username"value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
  	         </div>
  	         <div class="input-group">
  	              <label>Email</label>
  	              <input type="email" name="email"value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
  	         </div>
             <div class="input-group">
  	             <label>Password</label>
  	             <input type="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
  	         </div>
  	         <div class="input-group">
  	             <label>Confirm password</label>
  	             <input type="password"name="passwordC" value="<?php echo isset($_POST['passwordC']) ? $_POST['passwordC'] : ''; ?>">
  	         </div>
             <div class="input-group">
  	             <button href="index.php"type="submit" class="btn btn-primary">Register</button>
  	         </div>
		     <div>
                 <p>Already have an account? <a href="login.php">Log in</a></p>
             </div>
         </form>
          <?php require("templates/scripts.php"); ?>
	
     </body>
</html>