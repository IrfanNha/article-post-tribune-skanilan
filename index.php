<!-- 
halaman ini menampilkan judul "Artikel Terbaru", 
formulir pencarian, dan daftar postingan terbaru yang dapat diurutkan berdasarkan kategori. 
Pengguna juga dapat mengklik kategori untuk melihat postingan yang terkait dengan kategori tersebut. 
-->

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once 'components/header.php' ?>
  <style>
    .right-align {
      text-align: right;
    }
  </style>
  <title>Tribun Skanilan</title>
</head>

<body>
  <!-- nav -->
  <?php include 'components/navbar.php' ?>
  <!-- nav -->

  <div class="container my-5">

    <section class="mb-3">
      <div class="row">
        <div class="col-md-8">
          <div class="news">
            <h1>Artikel Terbaru</h1>
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group d-flex pt-3">
            <!-- SEARCHBAR -->
            <form action="search.php" method="GET">
              <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="Cari artikel..">
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
      <!-- dapat diurutkan sesuai kategori -->
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

    <!-- Menginclude load_posts.php -->
    <div id="postsContainer">
      <?php include 'load_posts.php'; ?>
    </div>

  </div>

  <?php include 'components/footer.php' ?>
</body>

</html>