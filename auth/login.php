<?php
session_start();
require_once "../db/conn.php";

// Periksa apakah pengguna sudah login
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header("Location: index.php");
  exit;
}

// Proses login jika ada data yang dikirimkan melalui form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query menggunakan prepared statement untuk memeriksa data pengguna di tabel "users"
  $query = "SELECT * FROM users WHERE username = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      // Login berhasil, simpan status login dalam session
      // Login ini mengambil SESSION user_rank sebagai acuan agar bisa mengkases halaman admin 
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $row['username'];
      $_SESSION['user_rank'] = $row['user_rank'];
      header("Location: index.php");
      exit;
    } else {
      // Password salah
      $error = "<script>alert('Password Salah');window.location.href = 'login.php';</script>";
    }
  } else {
    // Pengguna tidak ditemukan
    $error = "<script>alert('Username tidak valid');window.location.href = 'login.php';</script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once '../components/header.php' ?>

  <title>login</title>
</head>

<body class="bg-white">

  <!-- section login -->
  <section class="my-5 d-flex align-items-center justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card h-100 shadow border-0 rounded-3">
            <div class="card-body">
              <h3 class="card-title text-center mb-5">Form Login</h3>
              <form action="" method="POST">
                <div class="form-group mb-4">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" name="username" required placeholder="Masukkan username">
                </div>
                <div class="form-group mb-5">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" type="password" name="password" required placeholder="Masukkan password">
                </div>
                <div class="d-flex justify-content-between">
                  <div>
                    <input type="submit" value="Login" class="btn btn-success">
                    <a href="sign-up.php" class="btn btn-outline-primary">Daftar</a>
                  </div>
                  <a href="../index.php" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z" />
                      <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                    </svg>
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>


</html>