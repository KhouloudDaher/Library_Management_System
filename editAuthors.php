<?php 
	require("templates/databaseConnection.php");
    $currentPage = "Edit Authors";
	$id = $_GET['id'];

	if($_POST){
		extract($_POST);
		$authors = $_POST;
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
			$sql = "UPDATE `authors` SET `name`='$name' WHERE id = $id";
			$result = mysqli_query($dbc, $sql);
			if($result){
				header("Location: authors.php?id=$id");
		   	} else{
		   		die("Something went wrong, can't update entry into database");
			}
		}
	}else {
        $sql = "SELECT authors.id as authorID, name ,count(books.id) as nb_books
        FROM authors INNER JOIN books
        ON books.author_id = authors.id
		WHERE authors.id = $id
        GROUP BY books.author_id";
        $result = mysqli_query($dbc, $sql);
       if($result){
	        $authors = mysqli_fetch_all($result, MYSQLI_ASSOC);
	    } else {
	        die("Cannot get the data for the book");
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
            <?php foreach($authors as $author): ?>
			<h1>Edit Author - <?= $author['name']; ?></h1>
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
			<form action="editAuthors.php?id=<?=$id;?>" method="post">
				<div class="form-group">
					<label for="name">Name </label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="<?=$author['name']; ?>">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary " name="button">Edit</button>
				</div>
			</form>
            <?php endforeach; ?>
		</div>
		<?php require("templates/scripts.php"); ?>
	</body>
</html>