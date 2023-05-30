<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'components/header.php' ?>
  <style>
    body {
      height: 100vh;
    }
  </style>
  <title>Kategori</title>
</head>

<body>
  <?php include 'components/navbar.php' ?>

  <div class="container my-5">
    <section class="mb-3">
      <div class="row">
        <div class="col-md-8">
          <div class="news">
            <?php if (isset($_GET['kategori'])) { ?>
              <div class="news">
                <h1>Kategori <?php echo $_GET['kategori']; ?></h1>
              </div>
            <?php } else { ?>
              <div class="news">
                <h1>Kategori Search</h1>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group d-flex pt-3">
            <!-- SEARCHBAR -->
            <form action="" method="GET">
              <div class="input-group">
                <select class="form-select" name="kategori">
                  <option value="">Pilih Kategori</option>
                  <option value="pendidikan">pendidikan</option>
                  <option value="teknologi">teknologi</option>
                  <option value="politik">politik</option>
                  <option value="sains">sains</option>
                  <option value="kehidupan">kehidupan</option>
                  <option value="otomotif">otomotif</option>
                  <option value="random">random</option>
                  <!-- Tambahkan pilihan kategori sesuai dengan yang Anda butuhkan -->
                </select>
                <button class="btn btn-danger" type="submit">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                  </span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <hr>
      <ul class="nav justify-content-center bg-light py-2 mb-5">
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=pendidikan">Pendidikan</a>
        </li>
        <li class="nav-item">

        </li>
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=teknologi">Teknologi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=politik">Politik</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=sains">Sains</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=kehidupan">Kehidupan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=otomotif">Otomotif</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  text-muted" href="category.php?kategori=random">Random</a>
        </li>

      </ul>
    </section>

    <?php
    require_once 'db/conn.php';

    if (isset($_GET['kategori'])) {
      $kategori = $_GET['kategori'];

      // Query using prepared statement
      $query = "SELECT * FROM posts WHERE kategori = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $kategori);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result && $result->num_rows > 0) {
        $maxTextLength = 350;

        while ($row = $result->fetch_assoc()) {
          $text = $row['isi'];
          $judul = $row['judul'];
          $url_judul = urlencode($judul);
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
                    <p class="card-text"><?php echo $text ?></p>
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
    <?php
        }
      } else {
        echo "<div class='d-flex'><p class='mx-auto mt-5 fw-semibold'>Tidak ada postingan dalam kategori ini.</p></div>";
        $stmt->close();
      }
    } else {
      echo "<div class='d-flex'><p class='mx-auto mt-5 fw-semibold'>Kategori tidak ditemukan.</p></div>";
    }

    // Close the prepared statement and database connection
    $conn->close();
    ?>

  </div>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <?php include 'components/footer.php' ?>
</body>

</html>