<?php 
	require("templates/databaseConnection.php");
	$currentPage = "Add Author";
	if($_POST){
		extract($_POST);
		$errors = array();
		if(!$name){
			array_push($errors, "Please enter a name");
		} else if(strlen($name) < 1){
			array_push($errors, "Please enter more than 1 characters into the name");
		} else if(strlen($name) > 30){
			array_push($errors, "Cant be more than 30 characters");
		}
		if(empty($errors)){
			$name = mysqli_real_escape_string($dbc, $name);
			$sql = "INSERT INTO `authors` VALUES (NULL,'$name')";
			$result = mysqli_query($dbc, $sql);
			if($result && mysqli_affected_rows($dbc) > 0){
		   		header("Location: authors.php");
		   	} else{
		   		die("Something went wrong, can't add entry into database");
			}
		}
	} 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<?php require("templates/styles.php"); ?>
	</head>
	<body>
		<div class="container">
			<?php require("templates/nav.php"); ?>
			<h1>Add Authors</h1>
			<hr>
			<?php if($_POST): ?>
				<div class="alert alert-danger">
					<ul>
						<?php foreach($errors as $singleError): ?>
							<li><?= $singleError; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<form action="addAuthors.php" method="post">
				<div class="form-group">
					<label for="title">Author Name</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="button">Add</button>
				</div>
			</form>
		</div>
		<?php require("templates/scripts.php"); ?>
	</body>
</html>