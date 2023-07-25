<?php 
    require("templates/databaseConnection.php");
    $currentPage = "Book";
    $id = $_GET['id'];
    $sql = "SELECT books.id as bookID, title, year, description, name, authors.id as authorID 
      FROM books INNER JOIN authors 
      ON books.author_id = authors.id
       WHERE books.id = $id";
    $result = mysqli_query($dbc, $sql);
    if($result && mysqli_affected_rows($dbc) > 0){
        $book = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else if (mysqli_affected_rows($dbc) == 0){
        header("Location: error404.php");
    }else {
        die("Cannot get the data for the book");
    }



 ?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- Include the SweetAlert2 CSS file -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css">

         <!-- Include the SweetAlert2 JavaScript file -->
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.js"></script>

        <?php require("templates/styles.php"); ?>
    </head>
    <body>
        <div class="container">

        <?php require("templates/nav.php"); ?>

            <h2><?= $book['title'];?></h2>
            <h4><?= $book['name']; ?></h4>
            <p><small><?= $book['year'];?></small></p>
            <hr>
            <p><?= $book['description']; ?></p>

            <a href="editBooks.php?id=<?= $book['bookID']; ?>" class="btn btn-warning">Edit Book</a>
            <a  class="btn btn-danger"onclick="confirmDelete()">Delete Book</a>

        </div>

      <script>  
       function confirmDelete()
    {
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) 
        {
             window.location.href = "deleteBooks.php?id=<?php echo $id; ?>";
        }
     })
    }
    </script>

     <?php require("templates/scripts.php"); ?>
    </body>
</html>
