<?php 
    require("templates/databaseConnection.php");
    $currentPage = "Login";
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
        if(!$password){
			array_push($errors, "Please enter a password");
		}
        $sql = "SELECT registration.id as userID,username, password  FROM registration WHERE username='$username' ";
        $result = mysqli_query($dbc, $sql);
        $user_exist = mysqli_fetch_array($result);
        if (!$user_exist) {
          array_push($errors, "Username doesn't already exists");
        }
        else{
            if($user_exist['password'] != md5($password) )
            {
               array_push($errors, "incorrect password !");
            }
            if(empty($errors)){
              session_start();
              $user_id = $user_exist['userID'];
              $user_name = $user_exist['username'];
              $_SESSION['user_id'] = $user_id;
              $_SESSION['user_name'] = $user_name;
              header("Location:index.php");
              exit();
		    }
        }
    }
?>    
<!DOCTYPE html>
  <html>
     <head>
         <title>Login </title>
         <link rel="stylesheet" type="text/css" href="style.css">
     </head>
      <body>
          <div class="header">
             <h2>Log in</h2> 
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
         <form method="post" action="login.php" autocomplete="off">
               <div class="input-group">
                   <label>Username</label>
                   <input type="text" name="username"placeholder ="enter your username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
               </div>
               <div class="input-group">
                   <label>Password</label>
                   <input type="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" >
               </div>
             <div class="input-group">
                   <button href="index.php"type="submit" class="btn btn-primary">Log in</button>
               </div>
             <div>
                 <p>Not a member ? <a href="register.php">Create account</a></p>
             </div>
         </form>
         <?php require("templates/scripts.php"); ?>
      </body>
</html>   