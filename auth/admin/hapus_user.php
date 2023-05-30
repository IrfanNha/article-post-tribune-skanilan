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

if (isset($_GET['id'])) {
  $userId = $_GET['id'];

  $query = "DELETE FROM users WHERE id = $userId";
  $result = mysqli_query($conn, $query);

  if ($result) {

    header("Location: index.php");
    exit();
  } else {

    echo "<script>alert('gagal');window.location.href = 'index.php';</script>";
  }
} else {

  header("Location: index.php");
  exit();
}
