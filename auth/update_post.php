<?php
include '../db/conn.php';
session_start();

// Periksa apakah pengguna telah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

// Fungsi untuk mendapatkan data post berdasarkan ID dengan parameterized statement
function getPostById($id)
{
  global $conn;
  $query = "SELECT * FROM posts WHERE id_post = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_assoc();
}

// Fungsi untuk mengupdate postingan dengan parameterized statement
function updatePost($id, $judul, $author, $isi, $gambar)
{
  global $conn;
  $query = "UPDATE posts SET judul = ?, author = ?, isi = ?, gambar = ? WHERE id_post = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssss", $judul, $author, $isi, $gambar, $id);
  $stmt->execute();
}

// Cek apakah ada ID post yang dikirim melalui parameter URL
if (isset($_GET['id'])) {
  $postId = $_GET['id'];

  // Memanggil fungsi getPostById untuk mendapatkan data post berdasarkan ID
  $post = getPostById($postId);

  // Memastikan post dengan ID yang valid ditemukan
  if (!$post) {
    // Redirect atau berikan pesan error
    echo "Post not found.";
    exit;
  }
} else {
  // Jika tidak ada ID post, redirect atau berikan pesan error
  echo "Post ID not provided.";
  exit;
}

// Proses pembaruan post jika tombol "Simpan" ditekan
if (isset($_POST['submit'])) {
  // Mendapatkan nilai dari form
  $id = $_POST['id_post'];
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  $author = mysqli_real_escape_string($conn, $_POST['author']);
  $isi = $_POST['isi'];
  $kategori = $_POST['kategori'];

  // Cek jika variabel $isi mengandung '<script>'
  if (stripos($isi, '<script>') !== false) {
    echo "<script>alert('Karakter tidak diizinkan');</script>";
    exit;
  }

  // Cek keunikan judul sebelum memperbarui postingan
  $query = "SELECT * FROM posts WHERE judul = ? AND id_post != ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ss", $judul, $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $existingPost = $result->fetch_assoc();

  if ($existingPost) {
    // Judul sudah digunakan oleh postingan lain, berikan pesan error
    echo "<script>alert('Gagal');window.location.href = 'manage.php';</script>";
    exit;
  }

  // Cek apakah gambar baru diunggah
  if ($_FILES['gambar']['name']) {
    $gambar = $_FILES['gambar']['name'];
  } else {
    $gambar = $post['gambar']; // Gunakan gambar yang ada sebelumnya
  }

  // Update data post
  $query = "UPDATE posts SET judul = ?, author = ?, isi = ?, gambar = ?, kategori = ? WHERE id_post = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("ssssss", $judul, $author, $isi, $gambar, $kategori, $id);
  $stmt->execute();

  // Redirect atau berikan pesan sukses
  echo "<script>alert('Berhasil');window.location.href = 'manage.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../components/header.php' ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
  <link rel="stylesheet" href="../assets/css/style.css">

  <title>Update Post</title>
</head>

<body>
  <?php include 'navbar.php'; ?>

  <div class="container">

    <!--  -->
    <div class="my-5">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="justify-content-center">

          <div class="card shadow border-0">
            <div class="card-body">
              <div class="row ">
                <h2 class="mb-4">Update Post</h2>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                    <?php if (!empty($post['gambar'])) { ?>
                      <div>
                        <img src="../uploads/<?php echo $post['gambar']; ?>" class="" height="300vh">
                      </div>
                    <?php } ?>
                    <input type="file" class="form-control mt-2" name="gambar">
                  </div>
                  <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Judul</label>
                    <input type="text" required class="form-control w-100" name="judul" value="<?php echo $post['judul']; ?>">
                  </div>

                </div>
                <div class="col-md-6 mb-5">
                  <div class="mb-4">
                    <label for="formGroupExampleInput2" class="form-label">Author</label>
                    <input type="text" required class="form-control" name="author" value="<?php echo $post['author']; ?>">
                  </div>
                  <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-control" id="kategori" name="kategori">
                      <option value="pendidikan" <?php if ($post['kategori'] == 'pendidikan') echo 'selected'; ?>>Pendidikan</option>
                      <option value="teknologi" <?php if ($post['kategori'] == 'teknologi') echo 'selected'; ?>>Teknologi</option>
                      <option value="politik" <?php if ($post['kategori'] == 'politik') echo 'selected'; ?>>Politik</option>
                      <option value="kehidupan" <?php if ($post['kategori'] == 'kehidupan') echo 'selected'; ?>>Kehidupan</option>
                      <option value="otomotif" <?php if ($post['kategori'] == 'otomotif') echo 'selected'; ?>>Otomotif</option>
                      <option value="sains" <?php if ($post['kategori'] == 'sains') echo 'selected'; ?>>Sains</option>
                      <option value="random" <?php if ($post['kategori'] == 'random') echo 'selected'; ?>>Random</option>
                    </select>
                  </div>

                  <label for="formGroupExampleInput2" class="form-label">Isi Artikel</label>
                  <textarea id="editor" cols="40" rows="10" class="ckeditor" name="isi" required><?php echo $post['isi']; ?></textarea>
                </div>
                <div>
                  <input type="hidden" name="id_post" value="<?php echo $post['id_post']; ?>">
                  <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </div>
              </div>
            </div>
          </div>

        </div>

      </form>
    </div>
  </div>

  <script>
    CKEDITOR.replace('editor');
  </script>
</body>

</html>