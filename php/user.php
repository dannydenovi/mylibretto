<?php


require_once("config.php");
session_start();

if($_POST["action"] === "getInfo"){
    $sql = "SELECT * FROM users JOIN infos on users.id = infos.user_id WHERE id = " . $_SESSION["id"];
    if($result = $connection->query($sql)){
        $info = $result->fetch_assoc();
        echo json_encode($info);
    } else {
        echo json_encode(['error' => 'Errore nel caricamento delle info']);
    }
}
else if($_POST["action"] === "editUser"){
    $name = $connection->real_escape_string($_POST["name"]);
    $surname = $connection->real_escape_string($_POST["surname"]);
    $email = $connection->real_escape_string($_POST["email"]);
    $password = $connection->real_escape_string($_POST["password"]);
    $passwordConfirmation = $connection->real_escape_string($_POST["passwordConfirmation"]);
    $university = $connection->real_escape_string($_POST["university"]);
    $faculty = $connection->real_escape_string($_POST["faculty"]);
    $laude_value = $connection->real_escape_string($_POST["laude_value"]);
    $total_credits = $connection->real_escape_string($_POST["total_credits"]);

    $error = [];

    if(!$name)
        $error["name"] = "Nome non inserito";
    if(!$surname)
        $error["surname"] = "Cognome non inserito";
    if(!$email || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $error["email"] = "Email non valida";
    if($passwordConfirmation !== $password)
        $error["password"] = "Le password non coincidono";
    if(!$university)
        $error["university"] = "Università non inserita";
    if(!$faculty)
        $error["faculty"] = "Corso di studi non inserito";
    if(!$laude_value || !is_numeric($laude_value) || $laude_value < 30 || $laude_value > 39)
        $error["laude_value"] = "Valore lode non valido";
    if(!$total_credits || !is_numeric($total_credits) || $total_credits < 0)
        $error["total_credits"] = "Crediti totali non validi";

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if(count($error) > 0){
        echo json_encode($error);
    } else {
        if($password)
            $sql = "UPDATE users SET name = '$name', surname = '$surname', email = '$email', password = '$hashedPassword' WHERE id = " . $_SESSION["id"];
        else
            $sql = "UPDATE users SET name = '$name', surname = '$surname', email = '$email' WHERE id = " . $_SESSION["id"];
        if($connection->query($sql)){
            $sql = "UPDATE infos SET university = '$university', faculty = '$faculty', laude_value = '$laude_value', total_credits = '$total_credits' WHERE user_id = " . $_SESSION["id"];
            if($connection->query($sql)){
                echo json_encode(['success' => 'Modifiche salvate con successo']);
            } else {
                echo json_encode(['error' => 'Errore nel salvataggio delle modifiche']);
            }
        } else {
            echo json_encode(['error' => 'Errore nel salvataggio delle modifiche']);
        }
    }   
}