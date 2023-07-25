<?php 
	require("templates/databaseConnection.php");
	$id = $_GET['book_id'];
    $sql = "DELETE FROM bookmarks WHERE book_id = $id";
	$result = mysqli_query($dbc, $sql);
	if($result){
		header("Location:index.php");
	} else {
		die("Something went wrong, cant Delete bookmark");
	}
?>