<?php
session_start();
require_once "../../db/conn.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

// Periksa apakah pengguna memiliki hak akses admin
if ($_SESSION['user_rank'] !== 'admin') {
  header("Location: unauthorized.php");
  exit;
}


?>

<?php

require_once '../../db/conn.php';


if (isset($_POST['submit'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];
  $userRank = $_POST['user_rank'];


  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


  $query = "INSERT INTO users (username, password, user_rank) VALUES ('$username', '$hashedPassword', '$userRank')";
  $result = mysqli_query($conn, $query);

  if ($result) {

    header("Location: index.php");
    exit();
  } else {

    echo "<script>alert('Gagal menambah');window.location.href = 'index.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-0 shadow">
          <div class="card-body">
            <h2 class=" mb-3">Add User</h2>
            <form method="POST">
              <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="form-group mb-4">
                <label for="userRank">User Rank</label>
                <select class="form-control" id="userRank" name="user_rank" required>
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Add User</button>
              <a href="index.php" class="btn btn-danger">Cancel</a>
            </form>
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- Include Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>