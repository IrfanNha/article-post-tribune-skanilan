<?php
include '../db/conn.php';

// Periksa apakah parameter ID post telah diberikan
if (isset($_GET['id'])) {
  // Dapatkan ID post dari parameter
  $id = $_GET['id'];

  // Query untuk menghapus post berdasarkan ID
  $deleteQuery = "DELETE FROM posts WHERE id_post = '$id'";
  $deleteResult = mysqli_query($conn, $deleteQuery);

  if ($deleteResult) {
    // Post berhasil dihapus
    echo "<script>alert('berhasil dihapus');window.location('manage.php')</script>";
  } else {
    // Gagal menghapus post
    echo "<script>alert('gagal menghapus');window.location('index.php')</script>";
  }
} else {
  // Jika parameter ID tidak diberikan
  echo "<script>alert('id tidak ditemukan');window.location('index.php')</script>";
}

mysqli_close($conn);
