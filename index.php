<?php 
    require("templates/databaseConnection.php");
    $currentPage = "";
    $sql = "SELECT books.id as bookID, title, year, description, name, authors.id as authorID FROM books INNER JOIN authors ON books.author_id = authors.id";
    $result = mysqli_query($dbc, $sql);
    if(!$result){
        die("Something went wrong, can't get all the books");
    } else {
        $books = mysqli_fetch_all($result, MYSQLI_ASSOC); 
        // If the session variable is not set or if it contains an invalid user ID, redirect the user to the login page
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
           $message = "You need to be logged in to access this page";
           echo "<script>
                   setTimeout(function() {
                    if(confirm('$message')) {
                      window.location.href = 'login.php';
                    }
                  }, 5000); // show the popup message after 5 seconds
                 </script>";
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

            <h1>View Books</h1>
                <table class="table table-striped">
                    <thead>
                        <td>Title</td>
                        <td>Author</td>
                        <td>Description</td>
                        <td>Year Released</td>
                    </thead>
                    <tbody>
                        <?php foreach($books as $book): ?>
                            <tr>
                                <td><a href="book.php?id=<?=$book['bookID']?>"><?=$book['title'];?></a></td>
                                <td><?= $book['name'];?></td>
                                <td><?= substr($book['description'], 0 , 100);  ?></td>
                                <td><?= $book['year'];?></td>
                                <td><a href="addBookmarks.php?book_id=<?=$book['bookID']?>"><?= "ADD";?></a></td>
                            </tr>
                        <?php endforeach; ?>
 <!--                    <tr>
                            <td><a href="book.php">Harry Potter</a></td>
                            <td>J K Rowling</td>
                            <td>First Book in the Harry Potter Series.</td>
                            <td>1997</td>
                        </tr> -->
                    </tbody>
                </table>
                <a href="addBooks.php" class="btn btn-primary">Add Books</a>
       </div>
        <?php require("templates/scripts.php"); ?>
    </body>
</html>
