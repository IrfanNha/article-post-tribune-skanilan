<?php
session_start();
require_once "../../db/conn.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: unauthorized.php");
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

// Mengambil data users dari database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include '../../components/header.php' ?>
  <style>
    @import url('https://fonts.cdnfonts.com/css/olde-english');


    @import url('https://fonts.googleapis.com/css2?family=Arvo&display=swap');

    .navbar .tribune {
      font-size: xx-large;
    }
  </style>
  <title>Admin Dashboard </title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <nav class="navbar  bg-danger navbar-dark shadow">
    <div class="container">
      <a class="navbar-brand tribune" href="index.php">Tribune Skanilan</a>

      <div class="d-flex">
        <div class="dropdown">
          <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
              </svg>
              <span class="mx-1"><?php echo $_SESSION['username'] ?></span>
            </span>
          </button>
          <ul class="dropdown-menu border-0 shadow-sm">
            <li><a class="dropdown-item" href="">User : <?php echo $_SESSION['username'] ?></a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            <li><a class="dropdown-item" href="../sign-up.php">Tambah Akun</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h2 class="mb-4 ">Admin Dashboard - <?php echo $_SESSION['username'] ?></h2>

    <hr class="text-dark">
    <div class="card border-0 shadow">
      <div class="card-body">
        <div class="d-flex">
          <a href="tambah_user.php" class="btn btn-primary mb-4">Tambah User</a>
          <div class="ms-auto">
            <h5>Total User : <?php echo mysqli_num_rows($result); ?></h5>
          </div>
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
              <td>
                <h5>Username</h5>
              </td>
              <td>
                <h5>User Rank</h5>
              </td>
              <td>
                <h5>Action</h5>
              </td>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = "SELECT * FROM users";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
              $userRankClass = $row['user_rank'] === 'user' ? 'bg-success' : 'bg-primary';
            ?>
              <tr>
                <td><?php echo $row['username']; ?></td>
                <td><span class="rounded-sm text-light p-1 <?php echo $userRankClass ?>"><?php echo $row['user_rank']; ?></span></td>
                <td>
                  <?php if ($row['username'] !== $_SESSION['username']) { ?>
                    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="hapus_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                  <?php } else { ?>
                    <span class="text-muted">Sedang Digunakan</span>
                  <?php } ?>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>

        </table>
      </div>
    </div>

  </div>

  <!-- Include Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>