<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include '../../components/header.php' ?>
  <title>unauthorized</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
    }

    .container {
      text-align: center;
    }
  </style>
</head>
<!-- halaman ini untuk menangani jika user_rank bukan admin -->

<body>
  <div class="container">
    <h1 class="fw-semibold">Unauthorized</h1>
    <p>Anda tidak memiliki akses</p>
  </div>
</body>

</html>