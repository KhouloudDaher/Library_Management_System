<?php 
    require("templates/databaseConnection.php");
    $currentPage = "Authors";
    $sql = "SELECT authors.id as authorID, name ,count(books.id) as nb_books
                 FROM authors LEFT OUTER JOIN books
                 ON books.author_id = authors.id
                 GROUP BY authors.id";
     $result = mysqli_query($dbc, $sql);
     if($result && mysqli_affected_rows($dbc) > 0){
        $authors = mysqli_fetch_all($result, MYSQLI_ASSOC);
     } else if (mysqli_affected_rows($dbc) == 0){
         header("Location: error404.php");
     }else {
         die("Cannot get the data for the author");
     }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css">

        <!-- Include the SweetAlert2 JavaScript file -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.js"></script>
        <?php require("templates/styles.php"); ?>
    </head>
    <body>
        <div class="container">

            <?php require("templates/nav.php"); ?>

            <h1>View Authors</h1>

            <table class="table table-striped">
                <thead>
                    <td>Author</td>
                    <td>Number of Books</td>
                </thead>
                <tbody>
                  <?php foreach($authors as $author): ?>
                  <tr>
                        <td><?=$author['name'];?></td>
                        <td><?= $author['nb_books'];?></td>
                        <div class="container">
                         <td><a href="editAuthors.php?id=<?= $author['authorID']; ?>" class="btn btn-warning updateAuthor ">Edit Author</a></td>
                         <td><a class="btn btn-danger" onclick="confirmDelete()">Delete Author</a></td>
                        </div>
                  </tr> 
                  <?php endforeach; ?>
                </tbody>
            </table>
            <a href="addAuthors.php" class="btn btn-primary">Add Authors</a>
        </div>
        <script>  
                function confirmDelete()
                {
                    Swal.fire({
                             title: 'Are you sure?',
                              text: "All books related to this author will be deleted also !",
                              icon: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes, delete it!'
                           }).then((result) => {
                                 if (result.isConfirmed) 
                                 {
                                 window.location.href = "deleteAuthors.php?id=<?= $author['authorID']; ?>";
                                 }
                               })
                }
           </script>
        <?php require("templates/scripts.php"); ?>
    </body>
</html>
