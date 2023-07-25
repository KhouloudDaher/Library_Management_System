<?php 
    require("templates/databaseConnection.php");
    $currentPage = "Bookmark";
    $user_id = $_GET['user_id'];
    $sql = "SELECT bookmarks.id as BookmarkID,bookmarks.user_id as UserID,books.id as BookID,title 
                 FROM bookmarks INNER JOIN books
                 ON books.id = bookmarks.book_id
                 INNER JOIN registration
                 ON registration.id = bookmarks.user_id
                 WHERE bookmarks.user_id = $user_id";
     $result = mysqli_query($dbc, $sql);
     if($result && mysqli_affected_rows($dbc) >= 0){
        $bookmarks = mysqli_fetch_all($result, MYSQLI_ASSOC);
     } 
     else {
         die("Cannot get the data for the bookmarks list");
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

            <h1>View Your Bookmark List</h1>
            <table class="table table-striped">
                <thead>
                    <td>Book</td>
                </thead>
                <tbody>
                <?php foreach($bookmarks as $bookmark): ?>
                  <tr>
                     <td><?=$bookmark['title'];?></td>
                     <td><a href="removeBookmark.php" class="btn btn-warning">Remove</a></td>
                 </tr> 
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php require("templates/scripts.php"); ?>
    </body>
</html>
