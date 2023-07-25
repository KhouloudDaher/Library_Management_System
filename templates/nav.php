<!-- Include the SweetAlert2 CSS file -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.css">

<!-- Include the SweetAlert2 JavaScript file -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.0/dist/sweetalert2.min.js"></script>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./index.php">Book Library</a>
    </div>
   
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li class="<?php if ($currentPage == '' || isset($_SESSION['user_id'])): ?>active<?php endif; ?>">
      <a href="index.php<?php if (isset($_SESSION['user_id'])) echo '?user_id=' . $_SESSION['user_id']; ?>">View Book</a>
      </li>
      <li class="<?php if($currentPage == "Authors"):?>active<?php endif; ?>">
      <a href="authors.php">View Authors</a>
      </li> 
      <li class="<?php if (isset($_SESSION['user_name']) || $currentPage = "Registration"): ?>active<?php endif; ?>">
              <?php if (isset($_SESSION['user_name'])): ?>
              <li><a><?php echo "Welcome " . $_SESSION['user_name']; ?></a></li>
              <li><a href="bookmarkList.php?user_id=<?= $_SESSION['user_id']; ?>">View Bookmark List</a></li>
              <li><a onclick="confirmLogOut()">log out</a></li>
               <?php else: ?>
               <li><a href="login.php">login</a></li>
               <li><a href="register.php">sign up</a></li>
             <?php endif; ?>
      </li>
      </ul>
    </div>
  </div>
</nav>
<script>  
    function confirmLogOut()
    {
       Swal.fire({
       title: 'Are you sure?',
       text: "",
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yes, Log out!'
        }).then((result) => {
          if (result.isConfirmed) 
            {
              window.location.href = "logOut.php";
            }
        })
    }
</script>