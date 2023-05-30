<?php require_once 'db/conn.php'; ?>

<?php
// Memeriksa apakah cookie "hit" sudah ada
if (!isset($_COOKIE['hit'])) {
    // Jika cookie belum ada, inisialisasi 
    setcookie('hit', 1, time() + (86400 * 30), '/'); // Cookie berlaku selama 30 hari (86400 detik x 30)
} else {
    // Jika cookie sudah ada, tambahkan 1 ke nilai saat ini
    $hitCount = $_COOKIE['hit'] + 1;
    setcookie('hit', $hitCount, time() + (86400 * 30), '/'); // Perbarui nilai cookie dengan penambahan 1
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'components/header.php' ?>
    <title> <?php echo isset($row['judul']) ? $row['judul'] : "Post tidak ditemukan"; ?> </title>
</head>

<body>
    <?php require_once 'components/navbar.php' ?>


    <div class="container my-5">
        <?php
        $judul = isset($_GET['judul']) ? urldecode($_GET['judul']) : '';


        $query = "SELECT * FROM posts WHERE judul = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $judul);
        $stmt->execute();
        $result = $stmt->get_result();

        // Menampilkan data post tunggal
        if ($row = $result->fetch_assoc()) {
        ?>
            <article>
                <hr>
                <div class="text-center">
                    <img src="uploads/<?php echo $row['gambar']; ?>" class="" height="400vh">
                </div>
                <hr>

                <div class="my-2 mb-5">
                    <p class="text-muted">Author: <?php echo $row['author']; ?> / Pada : <?php echo $row['created_at'] ?> <a href="category.php?kategori=<?php echo $row['kategori'] ?>" class="text-decoration-none">#<?php echo $row['kategori'] ?></a></p>
                    <h1><?php echo $row['judul']; ?></h1>
                </div>

                <p><?php echo htmlspecialchars_decode($row['isi']) ?></p>
            </article>
        <?php
        } else {
            echo "<div class='d-flex'><p class='mx-auto mt-5 fw-semibold'>Tidak ada hasil yang ditemukan :\ .</p></div>";
        }
        $stmt->close();
        $conn->close();

        ?>
    </div>
    <br>
    <br>
    <?php include 'components/footer.php' ?>

</body>

</html>