<?php
include '../db/conn.php';
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once '../components/header.php' ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">


    <title>Dashboard</title>
</head>

<body>
    <?php include 'navbar.php' ?>
    <section class="my-5">
        <div class="container">
            <div class="container">
                <h2 class="my-3 mt-5 mb-3">Dashboard</h2>

                <?php
                $q = "SELECT COUNT(*) as total FROM posts";
                $r = mysqli_query($conn, $q);

                if ($r) {
                    $row = mysqli_fetch_assoc($r);
                    $tData = $row['total'];
                } else {
                    $tData = 0;
                }
                $qU = "SELECT COUNT(*) as tUser FROM users";
                $rU = mysqli_query($conn, $qU);

                if ($rU) {
                    $rowU = mysqli_fetch_assoc($rU);
                    $tUsers = $rowU['tUser'];
                } else {
                    $tUsers = 0;
                }
                ?>
                <div class="row mb-5">
                    <div class="col-md-4 mb-5 mb-md-0 ">
                        <div class="card shadow py-4 border-start border-0 border-start border-5 border-warning  border-opacity-75">

                            <div class="card-body d-flex text-dark">
                                <h5>Penayangan : <?php echo isset($_COOKIE['hit']) ? $_COOKIE['hit'] : 0; ?></h5>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="card shadow mb-5 mb-md-0 border-0 rounded-1 py-4  border-start border-0 border-start border-5 border-info border-opacity-75">
                            <div class="card-body d-flex text-dark">
                                <h5>Total Artikel : <?= $tData ?></h5>
                                <a href="manage.php" class="ms-auto text-decoration-none text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-right-square" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm4.5 5.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-5 mb-md-0 shadow border-0 rounded-1 py-4  border-start border-0 border-start border-5 border-danger  border-opacity-75">
                            <div class="card-body d-flex text-dark">
                                <h5>User : <?php echo $_SESSION['username'] ?> <span class="badge bg-primary"><?php echo $_SESSION['user_rank'] ?></span></h5>

                            </div>
                        </div>
                    </div>

                </div>



                <?php
                if (isset($_POST['submit'])) {
                    // Mendapatkan data dari form
                    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
                    $author = mysqli_real_escape_string($conn, $_POST['author']);
                    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
                    $isis = mysqli_real_escape_string($conn, $_POST['isi']);
                    $isi = htmlspecialchars($isis);
                    $gambar = $_FILES['gambar']['name'];
                    $gambar_tmp = $_FILES['gambar']['tmp_name'];
                    move_uploaded_file($gambar_tmp, "../uploads/" . $gambar);

                    // Cek apakah terdapat <script> dalam variabel $isi
                    if (strpos($isis, '<script>') !== false) {
                        echo "<script>alert('Karakter tidak diizinkan');window.location('index.php')</script>";
                    } else {
                        // Cek apakah judul sudah ada dalam tabel
                        $query = "SELECT * FROM posts WHERE judul = '$judul'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            // Judul sudah ada dalam tabel, tampilkan pesan peringatan
                            echo "<script>alert('Judul sudah ada');</script>";
                        } else {
                            // Query untuk memasukkan post ke database
                            $insertQuery = "INSERT INTO posts (judul, author, isi, gambar, kategori) VALUES ('$judul', '$author', '$isi', '$gambar', '$kategori')";
                            $insertResult = mysqli_query($conn, $insertQuery);

                            if ($insertResult) {
                                // Post berhasil ditambahkan
                                echo "<script>alert('berhasil ditambahkan');window.location('index.php')</script>";
                            } else {
                                echo "<script>alert('Gagal ditambahkan');window.location('index.php')</script>";
                            }
                        }
                    }
                }
                mysqli_close($conn);
                ?>


                <hr>
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="justify-content-center">
                            <form action="index.php" method="POST" enctype="multipart/form-data">
                                <h2>Tambah Post</h2>

                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="judul" class="form-label">Judul</label>
                                            <input type="text" name="judul" required class="form-control w-100" placeholder="masukkan judul">
                                        </div>
                                        <div class="mb-3">
                                            <label for="author" class="form-label">Author</label>
                                            <input type="text" name="author" required class="form-control" placeholder="masukkan author">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gambar" class="form-label">Gambar</label>
                                            <input type="file" name="gambar" required class="form-control" placeholder="masukkan gambar">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="kategori" class="form-label">Kategori:</label>
                                            <select class="form-control" id="kategori" name="kategori">
                                                <option value="pendidikan">Pendidikan</option>
                                                <option value="teknologi">Teknologi</option>
                                                <option value="politik">Politik</option>
                                                <option value="kehidupan">Kehidupan</option>
                                                <option value="otomotif">Otomotif</option>
                                                <option value="sains">Sains</option>
                                                <option value="random">Random</option>
                                            </select>
                                        </div>


                                    </div>
                                    <!-- ... -->
                                    <div class="col-md-6 mb-5">
                                        <label for="formGroupExampleInput2" class="form-label">Isi Artikel</label>
                                        <textarea id="editor" cols="40" rows="10" class="form-control editor" name="isi" required></textarea>
                                    </div>
                                    <!-- ... -->
                                    <div>

                                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
    </section>
    <!-- ... -->
    <script>
        CKEDITOR.replace('editor');
    </script>

</body>