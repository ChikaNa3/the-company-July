<?php
session_start();
require "../classes/User.php";

#Create object
$user_obj = new User;

#Call the method
$all_users = $user_obj->getAllUsers();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
    <!-- Link CSS -->
   <link rel="stylesheet" href="../assets/css/style.css">
  <!-- Bootstrap CDN Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

 
</head>
<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
    <div class="container">
      <a href="dashboard.php" class="navbar-brand">
        <h1 class="h3">The Company</h1>
      </a>
      <div class="navbar-nav">
        <span class="navbar-text"><?= $_SESSION['full_name'] ?></span>
        <form action="../actions/logout.php" class="d-flex ms-2" method="post">
          <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
        </form>
      </div>
    </div>
  </nav>
   <main class="row justify-content-center gx-0">
    <div class="col-6">
      <h2 class="text-center">User List</h2>

      <table class="table table-hover align-middle text-center">
        <thead>
          <tr>
            <th>Photo</th>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Username</th>
            <th>Edit|Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          
          while($user = $all_users->fetch_assoc()){
            ?>

            <tr>
              <td>
                <?php  
                if($user['photo']){
                  ?>
                  <img src="../assets/images/<?=$user['photo'] ?>" alt="<?= $user['photo']?>" class="d-bolck mx-auto dashboard-photo">

                 <?php 
                } else {
                  ?>
                    <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                  <?php
                }
                ?>
              </td>
              <td><?=$user['id'] ?></td>
              <td><?=$user['first_name'] ?></td>
              <td><?= $user['last_name'] ?></td>
              <td><?= $user['username'] ?></td>
              <td>
                <?php
                if($_SESSION['id'] == $user['id']){// true or false?
                  ?>

                  <!-- Edit Button -->
                  <a href="edit-user.php" class="btn btn-outline-warning" title="Edit">
                    <i class="fa-regular fa-pen-to-square"></i>
                  </a>
                  <!-- Delete Button  -->
                  <a href="delete-user.php" class="btn btn-outline-danger" title="Delete">
                    <i class="fa-regular fa-trash-can"></i>
                  </a>

                <?php
                } ?>
              </td>
            </tr>

            <?php
          }  ?>
        </tbody>
      </table>
    </div>
   </main>

<!-- Boosttrap JavaScript link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>