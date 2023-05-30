<?php
require_once "../db/conn.php";

// Proses sign up jika ada data yang dikirimkan melalui form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data pengguna ke tabel "users"
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        // Sign up berhasil
        header("Location: login.php");
        exit;
    } else {
        // Terjadi kesalahan saat memasukkan data pengguna
        $error = "<script>alert('Terjadi Kesalahan');window.location.href = 'sign-up.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once '../components/header.php' ?>
    <title>Halaman Sign Up</title>
</head>

<body>

    <div class="container my-5 ">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 shadow border-0 rounded-3">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-5">Form Sign Up</h3>
                        <form action="" method="POST">
                            <div class="form-group mb-4">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" required placeholder="Masukkan username">
                            </div>
                            <div class="form-group mb-5">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" type="text" name="password" required placeholder="Masukkan password">
                            </div>
                            <div class="d-flex">
                                <div>
                                    <input type="submit" class="btn btn-primary" value="Sign Up">
                                </div>
                                <a href="../index.php" class="btn btn-danger ms-auto">
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

    <script></script>
</body>

</html>