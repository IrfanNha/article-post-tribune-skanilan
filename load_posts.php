<?php
include 'db/conn.php';

// Mengambil data post dari database dengan pengurutan berdasarkan timestamp terbaru
$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);


$maxTextLength = 350;
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
  $hari = date('l', strtotime($timestamp));

  $kategori = $row['kategori'];
  $url_kategori = urlencode($kategori);
?>
  <div class="card mb-5 border-0 shadow">
    <div class="card-body">
      <div class="row">
        <?php if (!empty($row['gambar'])) { ?>
          <div class="col-md-4">
            <img src="uploads/<?php echo $row['gambar']; ?>" class="img-fluid mb-3">
          </div>
        <?php } ?>

        <div class="col-md-8">
          <a href="single_post.php?judul=<?php echo $url_judul; ?>" class="text-decoration-none text-dark">
            <h3 class="card-title"><?php echo $row['judul']; ?></h3>


            <p class="card-text">By : <?php echo $row['author']; ?></p>
            <p class="card-text"><?php echo $text; ?></p>
          </a>
          <a href="single_post.php?judul=<?php echo $url_judul; ?>" class="text-decoration-none">Lihat Selengkapnya</a>
          <br>
          <br>
          <a href="category.php?kategori=<?php echo $url_kategori; ?>" class="text-decoration-none">#<?php echo $kategori; ?></a>
        </div>
      </div>
    </div>
    <div class="card-footer d-flex">
      <p class="ms-auto fw-light text-muted"><?php echo $hari . ' ' . $row['created_at']  ?></p>
    </div>
  </div>
<?php }
$conn->close();
?>