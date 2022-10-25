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
            <button class="btn nav-link px-2 link-secondary" id="dashboard">Dashboard</button>
          </li>
          <li><button class="btn nav-link px-2 link-dark" id="libretto">Libretto</button></li>
          <li>
            <a href="#" class="nav-link px-2 link-dark">Orario Lezioni</a>
          </li>
          <li>
            <button class="btn nav-link px-2 link-dark" id="tasse" >Tasse</bitton>
          </li>
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <!--BEGIN USER IMAGE-->
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="mdo" class="rounded-circle user-image" />
            <!--END USER IMAGE-->
          </a>
          <ul class="dropdown-menu text-small">
            <!--TODO: Aggiungere il nome dell'utente-->
            <li><a class="dropdown-item" href="#">Impostazioni</a></li>
            <li><button role="button" id="logout-button" class="dropdown-item text-danger">Logout</button></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <!--END HEADER-->

  <!--BEGIN MAIN-->
  <main class="container" id="main">

  </main>
  <!--END MAIN-->

  <!--BEGIN FOOTER-->
  <footer class="footer py-3 bg-light fixed-bottom mt-4">
    <div class="container">
      <span class="text-muted">MyLibretto - Danny De Novi 2022 ©</span>
    </div>
  </footer>
  <!--END FOOTER-->
</body>
<script>
  var elements = [$("#dashboard"), $("#libretto"), $("#tasse")];

  $("#libretto").click(function() {
    $("#main").empty();
    selectedItemMenu($("#libretto"));
    $("#main").load("dist/html/libretto.html");
  });

  $("#dashboard").click(function() {
    $("#main").empty();
    selectedItemMenu($("#dashboard"));
    $("#main").load("dist/html/dashboard.html");
  });

  $("#tasse").click(function() {
    $("#main").empty();
    selectedItemMenu($("#tasse"));
    $("#main").load("dist/html/tasse.html");
  });

  function selectedItemMenu(activeElement){
    for (var i = 0; i < elements.length; i++) {
      elements[i].removeClass("link-secondary");
      elements[i].addClass("link-dark");
    }

    activeElement.addClass("link-secondary");
    activeElement.removeClass("link-dark");
  }

  $("document").ready(function() {
    $("#main").load("dist/html/dashboard.html");
  });

  $("#logout-button").click(function() {
    $.ajax({
      url: "php/loginManager.php",
      type: "POST",
      success: function(data) {
        window.location.href = "login.php";
      }
    });
  });
</script>
</html>