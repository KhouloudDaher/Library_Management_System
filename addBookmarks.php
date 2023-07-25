<?php 
	require("templates/databaseConnection.php");
	$currentPage = "Add to bookmark";
	$book_id = $_GET['book_id'];
	$user_id = $_SESSION['user_id'];

	$book_check ="SELECT * FROM bookmarks WHERE book_id =$book_id and user_id=$user_id";
	$result= mysqli_query($dbc, $book_check);
	$unique_book = mysqli_fetch_array($result);
	if($unique_book){
	  echo "<script>
       if (confirm('Book is already exists in bookmark list ! do you want to remove it ?')) {
        window.location.href = 'removeBookmark.php?book_id=$book_id?user_id=$user_id';
       } else {
		 window.location.href = 'index.php';
         }
       </script>";

	}
	else{
	 $sql = "INSERT INTO bookmarks VALUES (NULL,'$book_id', '$user_id')";
	 $result = mysqli_query($dbc, $sql);
	  if($result && mysqli_affected_rows($dbc) > 0){
		header("Location:index.php");
	  } else
	  {
		die("Cannot add book to bookmarks");
	  }
	
    }
?>
