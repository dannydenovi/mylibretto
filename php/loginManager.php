<?php

require_once('config.php');
session_start();

if ($_POST['action'] === "Register") {
    $error = [];

    if (!$_POST['name'])
        $error["name"] = "Inserisci il tuo nome";
    if (!$_POST['surname'])
        $error["surname"] = "Inserisci il tuo cognome";
    if (!$_POST['university'])
        $error["university"] = "Inserisci la tua università";
    if (!$_POST['faculty'])
        $error["faculty"] = "Inserisci il tuo corso di studi";
    if (!$_POST['cfu'] || !is_numeric($_POST['cfu']))
        $error["cfu"] = "Inserisci il numero di CFU del tuo corso di studi";
    if (!$_POST['laude'] || !is_numeric($_POST['laude']) || $_POST['laude'] < 30 || $_POST['laude'] > 39)
        $error["laude"] = "Inserisci il valore della lode";
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $error["email"] = "Inserisci una email valida";
    if (!$_POST['password'])
        $error["password"] = "Inserisci una password";
    if (!($_POST['passwordConfirmation'] === $_POST['password']) || !$_POST['passwordConfirmation'])
        $error["passwordConfirmation"] = "Le password non coincidono";


    if ($_POST["email"]) {
        $email = $_POST["email"];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $connection->query($sql);
        if ($result->num_rows > 0)
            $error["email"] = "Email già in uso";
    }

    if ($error) {
        echo json_encode($error);
    } else {

        $name = $connection->real_escape_string($_POST['name']);
        $surname = $connection->real_escape_string($_POST['surname']);
        $university = $connection->real_escape_string($_POST['university']);
        $faculty = $connection->real_escape_string($_POST['faculty']);
        $cfu = $connection->real_escape_string($_POST['cfu']);
        $laude = $connection->real_escape_string($_POST['laude']);
        $email = $connection->real_escape_string($_POST['email']);
        $password = $connection->real_escape_string($_POST['password']);


        $hashPasswd = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, surname, email, password) VALUES ('$name', '$surname', '$email', '$hashPasswd')";

        if ($connection->query($sql) === TRUE) {
            $last_id = $connection->insert_id;

            $sql = "INSERT INTO infos (user_id, university, faculty, total_credits, laude_value) VALUES ('$last_id', '$university', '$faculty', '$cfu', '$laude')";

            if ($connection->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo "Error " . $sql . ' ' . $connection->connect_error;
            }
        } else {
            echo "Error " . $sql . ' ' . $connection->connect_error;
        }
    }
} else if ($_POST["action"] === "Login") {


    $email = $connection->real_escape_string($_POST['email']);
    $password = $connection->real_escape_string($_POST['password']);


    if ($_SERVER["REQUEST_METHOD"] === 'POST') {

        if ($result = $connection->query("SELECT * FROM users WHERE email = '$email'")) {

            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (password_verify($password, $row['password'])) {

                $_SESSION['id'] = $row['id'];
                $_SESSION['fullname'] = $row['name']." ".$row['surname'];

                echo json_encode(['success' => true]);
            } else
                echo json_encode(['error' => 'Email o password errati']);
        } else
            echo json_encode(['error' => 'Utente non trovato']);
    }
} else {
    session_destroy();
    echo json_encode(['success' => true]);
}

$connection->close();
