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
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">

  <!-- Style -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="dist/css/style.css" />



  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

  <!--JavaScript-->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

  <title>MyLibretto - Dashboard</title>
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
            <a href="#" class="nav-link px-2 link-secondary">Dashboard</a>
          </li>
          <li><a href="#" class="nav-link px-2 link-dark">Libretto</a></li>
          <li>
            <a href="#" class="nav-link px-2 link-dark">Orario Lezioni</a>
          </li>
          <li>
            <a href="#" class="nav-link px-2 link-dark">Tasse</a>
          </li>
        </ul>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown"
            aria-expanded="false">
            <!--BEGIN USER IMAGE-->
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Portrait_Placeholder.png" alt="mdo"
              class="rounded-circle user-image" />
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
  <main class="container">
    <div class="row">
      <div class="col-12">
        <!--BEGIN TITLE-->
        <h1>Dashboard</h1>
        <!--END TITLE-->
        <h3>Riassunto carriera <?echo $_SESSION["fullname"];?>...</h3>
        <br>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">


                  <!--BEGIN CARD-->
                  <div class="col">
            <div class="card shadow-sm h-100">
              <div>
                <div class="card-body table-responsive">
                  <h4 class="card-title">Materie del giorno</h4>
                  <table class="table table-striped table-hover " id="table">
                    <thead>
                      <tr>
                        <th scope="col">Materia</th>
                        <th scope="col">Orario</th>
                        <th scope="col">Aula</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Programmazione Web</td>
                        <td>09:00 - 11:00</td>
                        <td>Lab. T-3</td>
                      </tr>
                      <tr>
                        <td>Sicurezza dei Sistemi</td>
                        <td>11:00 - 13:00</td>
                        <td>Lab. A-T-1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--END CARD-->

          <!--BEGIN CARD-->
          <div class="col">
            <div class="card shadow-sm h-100">
              <div>
                <canvas id="average"></canvas>
              </div>
              <div>
                <div class="card-body">
                  <h4 class="card-title mt-3">Media voti</h4>
                  <p class="card-text">
                    Media aritmetica dei voti: 30
                    <br>
                    Media pesata dei voti: 30
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--END CARD-->

          <!--BEGIN CARD-->
          <div class="col">
            <div class="card shadow-sm h-100">
              <img src="https://quickchart.io/chart?c={type:'progressBar',data:{datasets:[{data:[50]}]}}">
              <div>
                <div class="card-body">
                  <h4 class="card-title">Tasse</h4>
                  <p class="card-text">
                    Pagate: 140€
                    <br>
                    Non pagate: 60€
                  </p>
                  <div class="d-flex justify-content-between align-items-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--END CARD-->
          <!--BEGIN CARD-->
          <div class="col">
            <div class="card shadow-sm h-100">
              <img class="mt-3"
                src="https://quickchart.io/chart?c={type:'radialGauge',data:{datasets:[{data:[160]}]}, options: {domain: [0,180]}}">
              <div>
                <div class="card-body">
                  <h4 class="card-title">CFU</h4>

                  <p class="card-text">Mancanti: 20</p>
                  <br>
                  <div class="d-flex justify-content-between align-items-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--END CARD-->

          <!--BEGIN CARD-->
          <div class="col">
            <div class="card shadow-sm h-100">
              <canvas id="chart2"></canvas>
              <div>
                <div class="card-body">
                  <h4 class="card-title">Grafico voti</h4>
                  <p class="card-text">Più frequente: 30</p>
                  <div class="d-flex justify-content-between align-items-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--END CARD-->


          <!--BEGIN CARD-->
          <div class="col">
            <div class="card shadow-sm h-100">
              <img class="mt-3"
                src="https://quickchart.io/chart?c={type:'radialGauge',data:{datasets:[{data:[103.5]}]}, options: {domain: [0,110], animation: {animateRotate: true}, centerArea: {text: 103.5}}}">
              <div>
                <div class="card-body">
                  <h4 class="card-title">Base Voto Di Laurea</h4>

                  <p class="card-text">Previsto: 103.5</p>
                  <br>
                  <div class="d-flex justify-content-between align-items-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--END CARD-->
        </div>
        <br>
      </div>
    </div>
  </main>
  <!--END MAIN-->

  <!--BEGIN FOOTER-->
  <footer class="footer py-3 bg-light">
    <div class="container">
      <span class="text-muted">MyLibretto - Danny De Novi 2022 ©</span>
    </div>
  </footer>
  <!--END FOOTER-->
</body>


<script>
  const average = document.getElementById('average').getContext('2d');
  const averageElement = document.getElementById('chart2').getContext('2d');

  var data = [27, 25, 23, 30, 30, 30];
  var data2 = [28, 27, 26, 30, 30, 30];
  var type = "line"



  function buildChart(elem, type, data, data2) {
    const myChart = new Chart(elem, {
      type: type,
      data: {
        labels: ['Q1', 'Q2', 'Q3', 'Q4'],
        datasets: [{
          label: 'Aritmetica',
          data: data,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
          ],
          borderWidth: 1
        },
        {
          label: 'Ponderata',
          data: data2,
          backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
    return myChart;
  }

  function buildPieChart(elem, type, data, data2) {
    const myChart = new Chart(elem, {
      type: type,
      data: {
        labels: ['Q1', 'Q3', 'Q4', 'Q5', 'Q6'],

        datasets: [{
          data: [27, 27, 23, 28, 30, 29],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 40, 132, 0.2)',
            'rgba(245, 99, 132, 0.2)',
            'rgba(124, 99, 132, 0.2)',
            'rgba(255, 99, 32, 0.2)',
            'rgba(255, 125, 132, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
          ],
          borderWidth: 1
        }]
      }
    });
  }

  function buildProgress(elem, type, data) {


    const myChart = new Chart(elem, {
      type: 'radialGauge',
      data: {
        datasets: [{
          data: data,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
          ],
          borderWidth: 1
        }]
      },
      options: {
        mantainAspectRatio: false,
        domain: [0, 250]
      }
    });
  }




  var firstChart = buildChart(average, type, data, data2);
  buildPieChart(averageElement, "pie", data, data2)



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