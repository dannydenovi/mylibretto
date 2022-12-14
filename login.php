<?php
session_start();
if (isset($_SESSION['id'])) {
    header('location: index.php');
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

    <title>MyLibretto - Login</title>
</head>

<body class="text-center login-background" cz-shortcut-listen="true">
    <section class="vh-100 login-background">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="" id="mode-text">Accedi</h3>
                            <p class="text-danger" id="error"></p>
                            <div id="form-body">
                                
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="button" id="action">Login</button>
                            <button type="button" class="btn btn-outline-secondary btn-lg btn-block" id="register-login">Registrati</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<script src="./dist/js/loginManager.js"></script>
<script>
    $(document).ready(function() {
        generateLogin();
    });

    //Quando viene cliccato il tasto "Registrati" viene cambiato il testo del bottone e viene mostrato il form per la registrazione
    //?? condizionato dal fatto che il bottone sia "Registrati" e non "Login"
    $("#register-login").click(function() {
        $("#error").text("");
        if ($("#register-login").text() == "Registrati") {
            generateRegister();
        } else {
            generateLogin();
        }
    });
    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            $("#action").click();
        }
    });
    //Quando viene cliccato il tasto "Login" viene effettuato il login
    //Nel caso in cui il bottone sia "Registrati" viene effettuata la registrazione
    $("#action").click(function() {
        if ($("#action").text() === "Login") {
            login();
        } else {
            register();
        }
    });

    function login()??{
            $.ajax({
                url: "php/loginManager.php",
                type: "POST",
                data: {
                    action: "Login",
                    email: $("#email").val(),
                    password: $("#password").val(),
                },
                success: function(data) {
                    //Nel caso di successo viene reindirizzato alla pagina principale
                    var json = JSON.parse(data);
                    if (json.success) {
                        window.location.href = "http://mylibrettoprogetto.altervista.org";
                    } else {
                        $("#error").text("Email o password errati");
                        $("#email").addClass("is-invalid");
                        $("#password").addClass("is-invalid");
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        }
    

    function register(){
        $.ajax({
                url: "php/loginManager.php",
                type: "POST",
                data: {
                    action: "Register",
                    name: $("#name").val(),
                    surname: $("#surname").val(),
                    university: $("#university").val(),
                    faculty: $("#faculty").val(),
                    cfu: $("#cfu").val(),
                    laude: $("#laude").val(),
                    email: $("#email").val(),
                    password: $("#password").val(),
                    passwordConfirmation: $("#password-confirmation").val()
                },
                success: function(data) {
                    //Nel caso di successo viene reindirizzato alla pagina principale per effettuare il login
                    json = JSON.parse(data);
                    var result = validate(json);
                    if (result) {
                        window.location.href = "http://mylibrettoprogetto.altervista.org";
                    }
                },
                error: function(error) {
                    $("#error").text("Email o password errati");
                }
            });
    }

</script>