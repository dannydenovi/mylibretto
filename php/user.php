<?php


require_once("config.php");
session_start();

$method = $_SERVER['REQUEST_METHOD'];


if ($method === "GET") {
    $sql = "SELECT name, surname, email, user_id, total_credits, laude_value,faculty, university FROM users JOIN infos on users.id = infos.user_id WHERE id = " . $_SESSION["id"];
    if ($result = $connection->query($sql)) {
        $info = $result->fetch_assoc();
        echo json_encode($info);
    } else {
        echo json_encode(['error' => 'Errore nel caricamento delle info']);
    }
} else if ($method === "PUT") {
    parse_str(file_get_contents('php://input'), $_PUT);
    $name = $connection->real_escape_string($_PUT["name"]);
    $surname = $connection->real_escape_string($_PUT["surname"]);
    $email = $connection->real_escape_string($_PUT["email"]);
    $password = $connection->real_escape_string($_PUT["password"]);
    $passwordConfirmation = $connection->real_escape_string($_PUT["passwordConfirmation"]);
    $university = $connection->real_escape_string($_PUT["university"]);
    $faculty = $connection->real_escape_string($_PUT["faculty"]);
    $laude_value = $connection->real_escape_string($_PUT["laude_value"]);
    $total_credits = $connection->real_escape_string($_PUT["total_credits"]);

    $error = [];

    if (!$name)
        $error["name"] = "Nome non inserito";
    if (!$surname)
        $error["surname"] = "Cognome non inserito";
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $error["email"] = "Email non valida";
    if ($passwordConfirmation !== $password)
        $error["password"] = "Le password non coincidono";
    if (!$university)
        $error["university"] = "Università non inserita";
    if (!$faculty)
        $error["faculty"] = "Corso di studi non inserito";
    if (!$laude_value || !is_numeric($laude_value) || $laude_value < 30 || $laude_value > 39)
        $error["laude_value"] = "Valore lode non valido";
    if (!$total_credits || !is_numeric($total_credits) || $total_credits < 0)
        $error["total_credits"] = "Crediti totali non validi";

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if (count($error) > 0) {
        echo json_encode($error);
    } else {
        $sql = "UPDATE users SET name = '$name', surname = '$surname', email = '$email'";
        if ($password)
            $sql .= ", password = '$hashedPassword'";
        $sql .= " WHERE id = " . $_SESSION["id"];
        if ($connection->query($sql)) {
            $sql = "UPDATE infos SET university = '$university', faculty = '$faculty', laude_value = '$laude_value', total_credits = '$total_credits' WHERE user_id = " . $_SESSION["id"];
            if ($connection->query($sql)) {
                echo json_encode(['success' => 'Modifiche salvate con successo']);
            } else {
                echo json_encode(['error' => 'Errore nel salvataggio delle modifiche']);
            }
        } else {
            echo json_encode(['error' => 'Errore nel salvataggio delle modifiche']);
        }
    }
} else if ($method == "DELETE") {
    parse_str(file_get_contents('php://input'), $_DELETE);
    $passwordDeletion = $connection->real_escape_string($_DELETE["passwordDeletion"]);
    $sql = "SELECT password FROM users WHERE id = " . $_SESSION["id"];

    if ($result = $connection->query($sql)) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (password_verify($passwordDeletion, $row['password'])) {

            $sql = "DELETE FROM users WHERE id = " . $_SESSION["id"];

            if ($connection->query($sql)) {
                session_destroy();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Errore nell\'eliminazione dell\'account']);
            }
        } else
            echo json_encode(['passwordDeletion' => 'Email o password errati' . $passwordDeletion]);
    } else {
        echo json_encode(['error' => 'Errore nell\'eliminazione dell\'account']);
    }
}
