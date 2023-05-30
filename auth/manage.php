<?php
include '../db/conn.php';
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}


?>
<?php
include '../db/conn.php';

// Fungsi untuk mendapatkan data post
function getPosts()
{
  global $conn;
  $query = "SELECT * FROM posts ORDER BY created_at DESC"; // Menambahkan klausa ORDER BY
  $result = mysqli_query($conn, $query);
  return $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../components/header.php' ?>
  <link rel="stylesheet" href="../assets/css/style.css">

  <title>Manage Berita</title>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h2 class="my-3 mt-5">Manage Artikel</h2>
    <hr>

    <?php
    // Memanggil fungsi getPosts untuk mendapatkan data post
    $result = getPosts();

    $maxTextLength = 60;
    // Menampilkan data post dalam bentuk HTML
    while ($row = mysqli_fetch_assoc($result)) {
      $judul = $row['judul'];
      $url_judul = urlencode($judul);
      $text = $row['isi'];
      $texts = htmlspecialchars_decode($text); // Menghapus semua tag HTML
      $text = strip_tags($texts);
      if (strlen($text) > $maxTextLength) {
        $text = substr($text, 0, $maxTextLength) . ' ...';
      }
      $timestamp = $row['created_at'];
      $hari = date('l', strtotime($timestamp)); ?>

      <div class="card mb-5 border-0 shadow">
        <div class="card-body">
          <div class="row">
            <?php if (!empty($row['gambar'])) { ?>
              <div class="col-md-4">
                <img src="../uploads/<?php echo $row['gambar']; ?>" class="img-fluid">
              </div>
            <?php } ?>
            <div class="col-md-8">
              <h3 class="card-title"><?php echo $row['judul']; ?></h3>
              <p class="card-text"><?php echo $row['author']; ?></p>
              <p class="card-text"><?php echo $text; ?></p>
              <a href="update_post.php?id=<?php echo $row['id_post']; ?>" class="btn btn-primary m-1">Update</a>
              <a onclick="confirm('apakah anda ingin mengahapus post ini?')" href="hapus_post.php?id=<?php echo $row['id_post']; ?>" class="btn btn-danger  m-1">Delete</a>
              <a href="../single_post.php?judul=<?php echo $url_judul; ?>" class="btn btn-warning text-light  m-1">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                  </svg>
                </span>
                Lihat
              </a>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <p class="ms-auto fw-light text-muted">terakhir diupdate <?php echo $hari . ' ' . $row['created_at']  ?></p>
        </div>
      </div>
    <?php } ?>
  </div>

</body>

</html>