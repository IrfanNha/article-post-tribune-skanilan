<nav class="navbar navbar-expand-lg bg-danger navbar-dark shadow">
  <div class="container">
    <a class="navbar-brand tribune" href="index.php">Tribune Skanilan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="search.php">Search</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="category.php">Category</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <div class="dropdown">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) { ?>
              <!-- Jika pengguna telah login -->
              <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                  </svg>
                </span>
              </button>
              <ul class="dropdown-menu border-0 shadow-sm">
                <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
              </ul>
            <?php } else { ?>
              <!-- Jika pengguna belum login -->
              <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                  </svg>
                </span>
              </button>
              <ul class="dropdown-menu border-0 shadow-sm">
                <li><a class="dropdown-item" href="auth/login.php">Login</a></li>
                <li><a class="dropdown-item" href="auth/sign-up.php">Tambah Akun</a></li>
              </ul>
            <?php } ?>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>