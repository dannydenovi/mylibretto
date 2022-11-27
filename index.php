<?php

session_start();

if (!isset($_SESSION['id'])) {
  header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">

  <!-- Style -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="dist/css/style.css" />

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <!--JavaScript-->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

  
  <title>MyLibretto</title>
</head>
<body>
  <!--BEGIN HEADER-->
  <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <b>MyLibretto</b>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li>
            <span class="nav-link px-2 link-secondary" id="dashboard">Dashboard</span>
          </li>
          <li><span class="nav-link px-2 link-dark" id="libretto">Libretto</span></li>
          <li>
            <span class="nav-link px-2 link-dark" id="orarioLezioni">Orario Lezioni</span>
          </li>
          <li>
            <span class="nav-link px-2 link-dark" id="tasse" >Tasse</span>
          </li>
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <!--BEGIN USER NAME-->
            <span class="text-dark" id="namePlace"></span>
            <!--END USER NAME-->
          </a>
          <ul class="dropdown-menu text-small">
            <li><span class="dropdown-item" id="impostazioni" >Impostazioni</span></li>
            <li><button role="button" id="logout-button" class="dropdown-item text-danger">Logout</button></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <!--END HEADER-->

  <!--BEGIN MAIN-->
  <main class="container mb-5" id="main">

  </main>
  <!--END MAIN-->

  <!--BEGIN FOOTER-->
  <footer class="footer py-3 bg-light fixed-bottom mt-4">
    <div class="container">
      <a href="https://github.com/dannydenovi/mylibretto" class="text-muted">MyLibretto - Danny De Novi 2022 ©</a>
    </div>
  </footer>
  <!--END FOOTER-->
</body>
<script src="./dist/js/indexManager.js"></script>
</html>