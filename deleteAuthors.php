<?php 
	require("templates/databaseConnection.php");
	$id = $_GET['id'];
	$sql = "DELETE authors,books FROM authors INNER JOIN books 
    ON books.author_id = authors.id 
    WHERE authors.id = $id";
	$result = mysqli_query($dbc, $sql);
	if($result){
		header("Location:authors.php");
	} else {
		die("Something went wrong, cant Delete author");
	}
?>