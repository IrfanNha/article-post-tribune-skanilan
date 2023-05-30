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
include '../../db/conn.php';

if (isset($_GET['id'])) {
  $userId = $_GET['id'];

  $query = "SELECT * FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $username = $row['username'];
    $password = $row['password'];
    $userRank = $row['user_rank'];
  } else {
    header("Location: index.php");
    exit();
  }
} else {
  header("Location: index.php");
  exit();
}

if (isset($_POST['submit'])) {
  $newUsername = $_POST['username'];
  $newUserRank = $_POST['user_rank'];
  $updatePassword = false;
  $newPassword = "";

  if (!empty($_POST['password'])) {
    $newPassword = $_POST['password'];
    $updatePassword = true;
  }

  if ($updatePassword) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $query = "UPDATE users SET username = ?, password = ?, user_rank = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $newUsername, $hashedPassword, $newUserRank, $userId);
  } else {
    $query = "UPDATE users SET username = ?, user_rank = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $newUsername, $newUserRank, $userId);
  }

  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    header("Location: index.php");
    exit();
  } else {
    echo "<script>alert('gagal edit user')</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include '../../components/header.php' ?>
  <title>Edit User</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow border-0">
          <div class="card-body">
            <h2 class="mb-3">Edit User</h2>
            <form method="POST">
              <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" required>
              </div>
              <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan Untuk mempertahankan password">
              </div>
              <div class="form-group mb-4">
                <label for="userRank">User Rank</label>
                <select class="form-control" id="userRank" name="user_rank" required>
                  <option value="user" <?php if ($userRank === 'user') echo 'selected'; ?>>User</option>
                  <option value="admin" <?php if ($userRank === 'admin') echo 'selected'; ?>>Admin</option>
                </select>
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
              <a href="index.php" class="btn btn-danger">Batal</a>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>